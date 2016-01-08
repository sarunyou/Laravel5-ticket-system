<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TicketFormRequest; #require request from that i create to use request
use App\Ticket;#require model for create
use Illuminate\Support\Facades\Mail;

class TicketsController extends Controller
{
    public function create()
    {
        return view('tickets.create');
    }
    public function store(TicketFormRequest $request)
    {
        $slug = uniqid();
        $ticket = new Ticket(array(
        'title' => $request->get('title'),
        'content' => $request->get('content'),
        'slug' => $slug,
      ));
        $ticket->save();

        $data = array(
              'ticket' => $slug,
          );

          Mail::send('emails.ticket', $data, function ($message) {
              $message->from('sarunyouwhang11@gmail.com', 'Learning Laravel');

              $message->to('sarunyouwhang11@gmail.com')->subject('There is a new ticket!');
          });

        return redirect('/contact')->with('status', 'Your ticket has been created! Its unique id is: '.$slug);
    }
    public function index()
    {
        $tickets = Ticket::all();

        return view('tickets.index')->with('tickets', $tickets);
    }
    public function show($slug)
    {
        //  $product = Product::find($id);
    // return view('products.show')->with('product', $product);
    //  $ticket = Ticket::find($slug);
     $ticket = Ticket::whereSlug($slug)->firstOrFail();
      $comments = $ticket->comments()->get();
        return view('tickets.show')
                  ->with('ticket', $ticket)
                  ->with('comments',$comments);
    }

    public function edit($slug)
    {
        $ticket = Ticket::whereSlug($slug)->firstOrFail();

        return view('tickets.edit')->with('ticket', $ticket);
    }

    public function update($slug, TicketFormRequest $request)
    {
        $ticket = Ticket::whereSlug($slug)->firstOrFail();
        $ticket->title = $request->get('title');
        $ticket->content = $request->get('content');
        if ($request->get('status') != null) {
            $ticket->status = 0;
        } else {
            $ticket->status = 1;
        }
        $ticket->save();

        return redirect(action('TicketsController@edit', $ticket->slug))->with('status', 'The ticket '.$slug.' has been updated!');
    }
    public function destroy($slug)
    {
        $ticket = Ticket::whereSlug($slug)->firstOrFail();
        $ticket->delete();

        return redirect('/tickets')->with('status', 'The ticket '.$slug.' has been deleted!');
    }
}
