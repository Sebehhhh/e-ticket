<?php
namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    // Menampilkan daftar tiket
    public function userTickets()
    {
        $tickets = Ticket::with(['event', 'user'])->get(); // Menampilkan tiket beserta event dan user
        return view('orders.users.ticketUsers', compact('tickets'));
    }
    // Menampilkan daftar tiket
    public function index()
    {
        if (!Auth::check() || !Auth::user()->isAdmin) {
            return redirect('/home')->with('error', 'You do not have access to this page.');
        }

        $tickets = Ticket::with(['event', 'user'])->get(); // Menampilkan tiket beserta event dan user
        return view('tickets.index', compact('tickets'));
    }

    // Menampilkan formulir untuk membuat tiket baru
    public function create()
    {
        if (!Auth::check() || !Auth::user()->isAdmin) {
            return redirect('/home')->with('error', 'You do not have access to this page.');
        }
        $events = Event::all(); // Ambil semua event untuk dropdown
        $users = User::all(); // Ambil semua pengguna untuk dropdown
        return view('tickets.create', compact('events', 'users'));
    }

    // Menyimpan tiket baru
    public function store(Request $request)
    {
        if (!Auth::check() || !Auth::user()->isAdmin) {
            return redirect('/home')->with('error', 'You do not have access to this page.');
        }
        // Validasi input dari pengguna
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'ticket_quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);
    
        // Cek apakah sudah ada tiket untuk event yang sama oleh pengguna yang sama
        $existingTicket = Ticket::where('event_id', $request->event_id)->first();
    
        if ($existingTicket) {
            return redirect()->back()->withErrors(['event_id' => 'You already have a ticket for this event.'])->withInput();
        }
    
        // Membuat tiket baru dengan ID pengguna yang terautentikasi
        Ticket::create([
            'event_id' => $request->event_id,
            'user_id' => auth()->id(), // Mengambil ID pengguna yang sedang terautentikasi
            'ticket_quantity' => $request->ticket_quantity,
            'price' => $request->price,
        ]);
    
        return redirect()->route('tickets.index')->with('success', 'Ticket created successfully.');
    }

    // Menampilkan detail tiket
    public function show(Ticket $ticket)
    {
        if (!Auth::check() || !Auth::user()->isAdmin) {
            return redirect('/home')->with('error', 'You do not have access to this page.');
        }
        return view('tickets.show', compact('ticket'));
    }

    // Menampilkan formulir untuk mengedit tiket
    public function edit(Ticket $ticket)
    {
        if (!Auth::check() || !Auth::user()->isAdmin) {
            return redirect('/home')->with('error', 'You do not have access to this page.');
        }
        $events = Event::all(); // Ambil semua event untuk dropdown
        return view('tickets.edit', compact('ticket', 'events'));
    }

    // Memperbarui tiket yang ada
    public function update(Request $request, $id)
    {
        if (!Auth::check() || !Auth::user()->isAdmin) {
            return redirect('/home')->with('error', 'You do not have access to this page.');
        }
        // Validasi input dari pengguna
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'ticket_quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);
    
        $existingTicket = Ticket::where('event_id', $request->event_id)
                                ->where('id', '!=', $id) // Pastikan tidak memeriksa tiket yang sedang diedit
                                ->first();
    
        if ($existingTicket) {
            return redirect()->back()->withErrors(['event_id' => 'You already have a ticket for this event.'])->withInput();
        }
    
        // Update tiket
        $ticket = Ticket::findOrFail($id);
        $ticket->update([
            'event_id' => $request->event_id,
            'ticket_quantity' => $request->ticket_quantity,
            'price' => $request->price,
        ]);
    
        return redirect()->route('tickets.index')->with('success', 'Ticket updated successfully.');
    }

    // Menghapus tiket
    public function destroy(Ticket $ticket)
    {
        if (!Auth::check() || !Auth::user()->isAdmin) {
            return redirect('/home')->with('error', 'You do not have access to this page.');
        }
        $ticket->delete();
        return redirect()->route('tickets.index')->with('success', 'Ticket deleted successfully.');
    }
}