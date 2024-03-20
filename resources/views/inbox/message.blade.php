<div class="modal-header">
    <img class="mb-mail-avatar mr-2" alt="Mail Avatar" src="{{($inboxMessage->sender->avatar !=='' && @getimagesize(asset('public/images/users/'.$inboxMessage->sender->avatar))) ?asset('public/images/users/'.$inboxMessage->sender->avatar):asset('public/img/user.png')}}" style="width: 30px"> 
    <div>
        <h4 class="m-0">{{ $inboxMessage->sender->first_name }}</h4>
        <span class="font-12"> {{ date('dM,Y H:i',strtotime($inboxMessage->created_at)) }}</span>
    </div>
</div>
<div class="modal-body" style="max-height: 300px;">
    <b>{{ $inboxMessage->subject }}</b>
    <p>{{ $inboxMessage->message }}</p>
</div>
<div class="modal-footer"><button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button></div>