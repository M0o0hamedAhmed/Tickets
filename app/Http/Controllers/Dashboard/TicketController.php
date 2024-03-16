<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\TicketSubTypeEnum;
use App\Enums\TicketTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Models\Reply;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class TicketController extends BaseController
{

    public function __construct(
        private string $classView = 'dashboard.tickets.',
        public string $title = 'Tickets')
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $tickets = Ticket::latest()->get();
            return Datatables::of($tickets)
                ->addColumn('type',function ($ticket){
                    return view('components.badges.primary', ['badge' => $ticket->type->name,'backgroundClass' => $ticket->type->background()])->render();
                })
                ->addColumn('action', function ($ticket) {
                    $buttons = view('components.forms.buttons.icons.view', ['item' => $ticket])->render();
                    return $buttons;
                })
                ->addColumn('sub_type',function ($ticket){
                    return view('components.badges.primary', ['badge' =>$ticket->sub_type->name,'backgroundClass' => $ticket->sub_type->background()])->render();
                })
                ->addColumn('issuer_name',function ($ticket){
                    return  $ticket->issuers->name_ar;
                })
                ->addColumn('client_name',function ($ticket){
                    return  $ticket->client_id;
                })
                ->addColumn('closed_date',function ($ticket){
                    return view('components.badges.primary', ['badge' => $ticket->closed_at?->diffForHumans()])->render();
                })
                ->editColumn('issued_date', function ($ticket) {
                    return view('components.badges.primary', ['badge' => $ticket->created_at->diffForHumans()])->render();
                })
                ->escapeColumns([])
                ->make(true);
        } else {
            return view($this->classView . 'index')->with(['title' => $this->title]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $ticket =  new Ticket();
        $types = TicketTypeEnum::cases();
        return view($this->classView . 'parts.form',compact('types','ticket'))->render();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTicketRequest $request)
    {
        $data = $request->validated();
        try {
            $data['user_id'] = Auth()->user()->getAuthIdentifier();
            $data['sub_type'] = TicketSubTypeEnum::WAITING->value;
            $ticket = Ticket::query()->create($data);
            Log::info("Create Ticket: ticket created successfully with id {$ticket->id} by user id " . Auth::id() . ' and  name is ' . Auth::user()->name);
         return   $this->sendResponse($ticket);
        } catch (\Exception $e) {
            Log::error("Create Ticket : system can not   create ticket for this error {$e->getMessage()}");
            return $this->sendError($e->getMessage());
        }
    }


    public function show(Ticket $ticket)
    {
        return view($this->classView . '.parts.replies', compact('ticket'))->with(['title' => $this->title]);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        return view($this->classView . '.parts.form', compact('ticket'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTicketRequest $request, Ticket $ticket)
    {
        $data = $request->validated();
        try {
            $reply = new Reply();
            $reply->message = $data['message'];
            $reply->ticket_id = $ticket->id;
            $reply->user_id = Auth()->user()->getAuthIdentifier();
            $ticket->replies()->save($reply);
            Log::info("Update Ticket: ticket updated successfully with id {$ticket->id} by user id " . Auth::id() . ' and  name is ' . Auth::user()->name);
        }catch (\Exception $e){
            Log::error("Update Ticket : system can not   updated ticket for this error {$e->getMessage()}");
            abort(500);
        }

        return redirect()->back();
    }
}
