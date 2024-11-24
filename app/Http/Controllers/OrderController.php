<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Ticket;
use App\Models\TicketCode;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class OrderController extends Controller
{

public function userOrders()
{
    // Ambil semua order milik pengguna yang sedang terautentikasi
    $orders = Order::where('user_id', Auth::id())->get(); // Pastikan 'user_id' adalah kolom yang menghubungkan order dengan pengguna
    return view('orders.users.index', compact('orders'));
}
    public function index()
    {
        if (!Auth::check() || !Auth::user()->isAdmin) {
            return redirect('/home')->with('error', 'You do not have access to this page.');
        }

        // Ambil semua order milik pengguna
        $orders = Order::all();
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        if (!Auth::check() || !Auth::user()->isAdmin) {
            return redirect('/home')->with('error', 'You do not have access to this page.');
        }

        $today = now(); // Mendapatkan tanggal dan waktu saat ini
        $tickets = Ticket::where('ticket_quantity', '>', 0)
                         ->whereHas('event', function($query) use ($today) {
                             $query->where('event_date', '>', $today); // Hanya ambil tiket dengan tanggal event setelah hari ini
                         })
                         ->get();
    
        return view('orders.create', compact('tickets'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'ticket_id' => 'required|exists:tickets,id',
            'quantity' => 'required|integer|min:1|max:10',
        ]);
    
        // Temukan tiket berdasarkan ID
        $ticket = Ticket::find($request->ticket_id);
        
        // Cek apakah kuantitas tiket yang tersedia cukup
        if ($ticket->ticket_quantity < $request->quantity) {
            return redirect()->back()->withErrors(['quantity' => 'Not enough tickets available.']);
        }
    
        // Logika untuk menyimpan order
        $order = new Order();
        $order->ticket_id = $request->ticket_id;
        $order->quantity = $request->quantity;
        $order->user_id = auth()->id(); // Menyimpan ID pengguna yang membuat order
        $order->total_price = $ticket->price * $request->quantity; // Menghitung total harga
        $order->order_date = now();
        $order->status = 'pending'; // Atur status menjadi 'pending'
        $order->save();
    
        // Menghasilkan kode tiket
        for ($i = 0; $i < $request->quantity; $i++) {
            $ticketCode = new TicketCode();
            $ticketCode->order_id = $order->id;
            $ticketCode->code = strtoupper(Str::random(10)); // Menghasilkan kode tiket acak
            $ticketCode->save();
        }
    
        // Kurangi kuantitas tiket yang tersedia
        $ticket->ticket_quantity -= $request->quantity;
        $ticket->save();
    
        return redirect()->route('orders.index')->with('success', 'Order created successfully.');
    }

    public function show(Order $order)
    {
        // Mengambil kode tiket yang terkait dengan order
        $ticketCodes = $order->ticketCodes; // Pastikan relasi ini sudah didefinisikan di model Order
    
        // Mengonversi order_date ke objek Carbon jika diperlukan
        $orderDate = Carbon::parse($order->order_date);
    
        return view('orders.show', compact('order', 'ticketCodes', 'orderDate'));
    }

    public function rejectOrder($id)
{
    if (!Auth::check() || !Auth::user()->isAdmin) {
        return redirect('/home')->with('error', 'You do not have access to this page.');
    }

    // Temukan order berdasarkan ID
    $order = Order::findOrFail($id);

    // Cek apakah status order sudah 'pending' sebelum menolak
    if ($order->status !== 'pending') {
        return redirect()->back()->withErrors(['status' => 'Order cannot be rejected.']);
    }

    // Kembalikan stok tiket
    $ticket = Ticket::find($order->ticket_id);
    $ticket->ticket_quantity += $order->quantity; // Tambahkan kuantitas tiket yang dipesan
    $ticket->save();

    $order->delete(); // Menghapus order

    return redirect()->route('orders.index')->with('success', 'Order rejected and stock returned successfully.');
}
public function acceptOrder($id)
{
    if (!Auth::check() || !Auth::user()->isAdmin) {
        return redirect('/home')->with('error', 'You do not have access to this page.');
    }
    if (!Auth::check() || !Auth::user()->isAdmin) {
        return redirect('/home')->with('error', 'You do not have access to this page.');
    }
    // Temukan order berdasarkan ID
    $order = Order::findOrFail($id);

    // Cek apakah status order sudah 'pending' sebelum menerima
    if ($order->status !== 'pending') {
        return redirect()->back()->withErrors(['status' => 'Order cannot be accepted.']);
    }

    // Ubah status order menjadi 'completed'
    $order->status = 'completed';
    $order->save();

    return redirect()->route('orders.index')->with('success', 'Order accepted successfully.');
}
}