{{'';$chats=Conversation::getChats($row_id,$data);}}
@foreach($chats as $chat)

@if($chat->recipient_id != Session::get('account_id'))
<!-- chat item -->
<div class="alert alert-warning item" style="padding-top: 5px;padding-bottom: 5px;background-color: ">

    <p class="message">
        <a href="#" class="name">
            <small class="text-muted pull-right"><i class="fa fa-clock-o"></i>{{$chat->time_sent}}
                {{$chat->time_read=='1'?' <i class="fa fa-angle-double-right"></i>':''}}</small>                         
            @if(strpos(strtoupper($chat->sender), 'ADMIN')!==false)
            {{ucwords($chat->sender)}}
            @else
            {{HTML::link(URL::route('view_profile', array(
            'acc' => Session::get('account_id')
            )), ucwords($chat->sender)).'<br/>';                            
            }}
            @endif
        </a>
        {{$chat->message}}
    </p>

</div><!-- /.item -->
@else
<!-- chat item -->
<div class="alert alert-success item" style="padding-top: 10px;padding-bottom: 10px">

    <p class="message">
        <a href="#" class="name">
            <small class="text-muted pull-right"><i class="fa fa-clock-o"></i>{{$chat->time_sent}}
            </small>
            @if(strpos(strtoupper($chat->sender), 'ADMIN')!==false)
            {{ucwords($chat->sender)}}
            @else
            {{HTML::link(URL::route('view_profile', array(
            'acc' => $chat->sender_id
            )), ucwords($chat->sender)).'<br/>';                            
            }}
            @endif
        </a>
        {{$chat->message}}
    </p>

</div><!-- /.item -->
@endif
@endforeach