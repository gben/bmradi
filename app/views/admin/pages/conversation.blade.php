@extends('admin.layouts.default')
@section('content')

<!-- Right side column. Contains the navbar and content of the page -->

<!-- Content Header (Page header) -->
<section class="content-header no-margin">
    <h1 class="text-center">
        Conversations
    </h1>
</section>
@if ($errors->has()) <div class="callout callout-danger"><p> 
        @if($errors->has('email_cc')||$errors->has('email_bcc')||$errors->has('email_to'))
            <li>Please enter atleast one recipient</li>
        @endif
        @if($errors->has('subject'))
            <li>Please enter email subject</li>
        @endif
        @if($errors->has('message'))
            <li>Please enter message to send</li>
        @endif   
</p></div>

@endif
{{Session::get('_feedback')}}
<!-- Main content -->
<section class="content">
    <!-- MAILBOX BEGIN -->
    <div class="mailbox row">
        <div class="col-xs-12">
            <div class="box box-solid">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-3 col-sm-4">
                            <!-- BOXES are complex enough to move the .box-header around.
                                 This is an example of having the box header within the box body -->
                            <div class="box-header">
                                <i class="fa fa-inbox"></i>
                                <h3 class="box-title">INBOX</h3>
                            </div>

                            <!-- compose message btn -->
                            <a class="btn btn-block btn-primary" data-toggle="modal" data-target="#compose-modal"><i class="fa fa-comment-o"></i> New Chat</a>
                            @if(strtoupper(Session::get('account_type'))=='ADMIN')
                            <a class="btn btn-block btn-success" data-toggle="modal" data-target="#composeEmail-modal"><i class="fa fa-envelope-o"></i> Compose Email</a>
                            @endif
                            <!-- Navigation - folders-->
                            <div style="margin-top: 15px;">
                                <ul class="nav nav-pills nav-stacked">
                                    <li class="header">Folders</li>
                                    <li class="active"><a href="#"><i class="fa fa-inbox"></i> Conversations ({{Conversation::getMessageCount()}})</a></li>                                                   
                                </ul>
                            </div>
                        </div><!-- /.col (LEFT) -->
                        <div class="col-md-9 col-sm-8">
                            <div class="row pad">
                                <div class="col-sm-6">
                                    <label style="margin-right: 10px;">
                                        <input type="checkbox" id="check-all"/>
                                    </label>
                                    <!-- Action button -->
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default btn-sm btn-flat dropdown-toggle" data-toggle="dropdown">
                                            Action <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">                                                         
                                            <li><a href="#">Delete</a></li>
                                        </ul>
                                    </div>

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

                            {{Helpers::getConversationList()}} 
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