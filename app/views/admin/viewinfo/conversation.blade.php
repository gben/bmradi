<!-- Main content -->
{{ Form::open(array('name'=>'conversation','url'=>'/send/chat')) }}
<div class="box box-success">
    <div class="box-header">
        <i class="fa fa-comments-o"></i>
        <h3 class="box-title">Chat</h3>
    </div>
    <div class="box-body chat" id="chat-box">
        @include('admin.viewinfo.chat')
    </div><!-- /.chat -->
    <div class="box-footer">
        <div class="input-group">
            <input class="form-control" name="message" placeholder="Type message..."/>
            <div class="input-group-btn">
                <input type="button" name="sendchat" id="sendchat" value="Send" class="btn btn-success">
            </div>
        </div>
    </div>
</div><!-- /.box (chat box) --> 
{{Form::hidden('message_',$row_id)}}
{{ Form::close() }}
<script type="text/javascript">
    setInterval(function() {
        refreshChat();
    }, 60000);
    function refreshChat()
    {
        if($('[name="message_"]').length)
            $.get("<?php echo url(); ?>/chats/" + $('[name="message_"]').val(), function(data) {
                $("#chat-box").html(data);
            });
    }
    $("#sendchat").click(function() {
        if ($('[name="message"]').val().trim() == '')
        {
            $('[name="message"]').addClass('has-error');
            $('[name="message"]').attr('placeholder', 'enter message to send');
        }
        else
        {
            $.post($('[name="conversation"]').attr('action'),$('[name="conversation"]').serialize(),
            function(data)
            {
                $('[name="message"]').val('');
                refreshChat();
            });
        }
    });
</script>
@include('admin.includes.lessfooter')