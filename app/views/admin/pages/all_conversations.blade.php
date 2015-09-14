@extends('admin.layouts.default')
@section('content')

<!-- Right side column. Contains the navbar and content of the page -->

<!-- Content Header (Page header) -->
	        <section class="content-header">
<h1>
    All Conversations
    
</h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">Mailbox</li>
    <li class="active">All Conversations</li>
</ol>
</section>

{{Session::get('_feedback')}}
<!-- Main content -->
<section class="content">
    <!-- MAILBOX BEGIN -->
    <div class="mailbox row">
        <div class="col-xs-12">
            <div class="box box-solid">
                <div class="box-body">
                    <div class="row">

                        <div class="col-md-12 col-sm-11">
                            <div class="row pad">
                                <div class="col-sm-6">
                                    {{'';$outOf = (Session::get('rec_per_page') * (Input::get('page') == 0 ? 1 : Input::get('page')));
                                        $outOf = $outOf > Conversation::getConversationCount() ? Conversation::getConversationCount() : $outOf;}}
                                    <h3>Conversations{{" ( " . $outOf . " of ".Conversation::getConversationCount()." )"}}</h3>
                                </div>
                                <div class="col-sm-6 search-form">
                                    <form action="#" class="text-right">
                                        <div class="input-group">
                                            <input type="text" class="form-control input-sm" placeholder="Search">
                                            <div class="input-group-btn">
                                                <button type="submit" name="q" class="btn btn-sm btn-primary"><i class="fa fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div><!-- /.row -->

                            {{Helpers::getAllConversationList()}} 
                            {{'';/*$queries = DB::getQueryLog();
                            $last_query = end($queries);
                            print_r($last_query);*/}}

                        </div><!-- /.col (RIGHT) -->
                    </div><!-- /.row -->
                </div><!-- /.box-body -->

            </div><!-- /.box -->
        </div><!-- /.col (MAIN) -->
    </div>
    <!-- MAILBOX END -->

</section><!-- /.content -->

<!-- COMPOSE MESSAGE MODAL -->
<div class="modal fade" id="compose-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="fa fa-envelope-o"></i> Compose Chat</h4>
            </div>
            {{ Form::open(array('name'=>'chats','url'=>'/send/chat')) }}
            <div class="modal-body">
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon">Chat with:</span>
                        {{Conversation::getContactList()}}

                    </div>
                </div>

                <div class="form-group">
                    <textarea name="message" id="message" class="form-control" placeholder="Message" style="height: 120px;"></textarea>
                </div>

            </div>
            <div class="modal-footer clearfix">
                {{Form::hidden('message_',Helpers::getUniqueID())}}
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Discard</button>
                <input type="submit" name="sendMessage" id="sendMessage" value='Send Message' class="btn btn-primary pull-left">
            </div>
            {{Form::close()}}
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->

</div><!-- /.modal -->
<!-- COMPOSE MESSAGE MODAL -->
<div class="modal fade" id="composeEmail-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="fa fa-envelope-o"></i> Compose New Message</h4>
            </div>
            {{ Form::open(array('name'=>'emailmsg','url'=>'/send/email','files'=>true)) }}
            <div class="modal-body">
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon">TO:</span>
                        {{Conversation::getEmailContactList('email_to')}}
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon">CC:</span>
                        {{Conversation::getEmailContactList('email_cc')}}
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon">BCC:</span>
                        {{Conversation::getEmailContactList('email_bcc')}}
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon">Subject:</span>
                        {{Form::text('subject','',array('class'=>'form-control','placeholder'=>'Email subject'))}}
                    </div>
                </div>
                <div class="form-group">
                    <textarea name="message" id="email_message" class="form-control" placeholder="Message" style="height: 120px;"></textarea>
                </div>
                <div class="form-group">
                    <div class="">
<!--                        <i class="fa fa-paperclip"></i>btn btn-success btn-file -->Attachment
                        <input class="form-control" name="attachment[]" type="file">
                    </div>
                    <p class="help-block">Max. 32MB</p>
                </div>
            </div>
            <div class="modal-footer clearfix">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Discard</button>
                <button type="submit" id="sendEmailMessagew" class="btn btn-primary pull-left"><i class="fa fa-envelope"></i> Send Message</button>
            </div>
            {{Form::close()}}
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@stop