@extends('layouts.master')
@section('content')

<style type="text/css">
  @media only screen and (max-width: 768px) {
  #first {
    order: 1;
  }
  #second {
    bottom: 0;  }
 
}
.direct-chat-text p{

    white-space: pre-wrap;
 font-size: 15px;
 line-height: 15px;

 word-spacing: 0px;
}
.talkDeleteMessage{
  float: right;
  margin-top: -15px;
  display: none;
}
@media  screen and (max-width: 995px) {
 #second .products-list{
  max-height: 25vh !important;
 }
 #first .direct-chat-messages{
  min-height: 80vh !important;
 }
}
.direct-chat .right a{


  color : blue;
  text-decoration: underline;
  font-weight: 600;
}
</style>
<section class="content-header" style="margin-top: -35px; margin-bottom: 20px">
            <h1>
                <i style="color: green" class="fa fa-comments"> </i> {{ trans('/admin/chat/general.title.heading') }}
                <small>{{ trans('/admin/chat/general.title.sub_title') }}</small>
            </h1>
             <p> {{ trans('/admin/chat/general.title.page_description') }}</p>


            {!! MenuBuilder::renderBreadcrumbTrail(null, 'root', false)  !!}
        </section>
<div class="row">
  <div class="@if($receiver) col-md-4 @else col-md-12 @endif" id="second">
    <div class="box box-danger box-solid">
            <div class="box-header with-border ">
              <h3 class="box-title">{{ trans('/admin/chat/general.heading.user_list') }}</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove" onclick="makeFullView()"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <input type="text" class="form-control" placeholder="Search Users..." id='search_user'><br>
              <ul class="products-list product-list-in-box"  style="max-height: 75vh;overflow-y: scroll; font-size: 17px; color: black" id='user_lists' >
                 @foreach($users as $user)
                <li class="item active_chat" style="@if($receiver == $user->id)background: #D9EDF7;@endif">
                  <div class="product-img">
                    <img  src="{{ $user->image?'/images/profiles/'.$user->image:$user->avatar }}" style="width: 30px; border-radius: 50%; height: 30px;" alt="{{$user->first_name}} {{$user->last_name}}">
                  </div>
                  <div class="product-info">
                    <a href="{{route('message.read', ['id'=>$user->id])}}" class="product-title">{{$user->first_name}} {{$user->last_name}}
                      @if(Cache::has('user-is-online-' .$user->id))
                      <span class="label label-success pull-right" style="margin-right: 5px;">Online</span>
                      @else
                       <span class="label label-default pull-right" style="margin-right: 5px;">Offline</span>
                      @endif
                    </a>
                  </div>
                </li>
                @endforeach
               
                <!-- /.item -->
              </ul>
            </div>
            <!-- /.box-body -->
         
            <!-- /.box-footer -->
          </div>
  </div>
  @if($receiver)
  <div class="col-xs-12 col-sm-12 col-md-8" id="first">
          <!-- DIRECT CHAT SUCCESS -->
          <div class="box box-primary  box-solid direct-chat direct-chat-info">
            <div class="box-header with-border">
              <h3 class="box-title">{{$rcv_user->first_name}} {{$rcv_user->last_name}}</h3>

              <div class="box-tools pull-right">
                <span data-toggle="tooltip" title="" class="badge bg-light-blue" data-original-title="{{$total_unseen_message}} New Messages">{{$total_unseen_message}}</span>
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="" data-widget="chat-pane-toggle" data-original-title="My Contacts">
                  <i class="fa fa-comments"></i></button>

              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <!-- Conversations are loaded here -->
              <div class="direct-chat-messages msg_history" style="min-height: 76.8vh;visibility: hidden;" id='userlivechatbox'  data-total-message = "{{ $totalMessage }}" data-receiver="{{$receiver}}">
                <!-- Message. Default to the left -->
                
                 <div  id='chathistory'  v-if='isLoaded' style="clear: both;">
                   @if($rcv_user)
                  <div v-for = '(message,index) in messageobj'  :key='message.id'  v-if='isLoaded' class="chatbox"> 
                    <div class="direct-chat-msg" v-if='message.sender.id == authuser' v-bind:id='"message-"+message.id'>
                      <div class="direct-chat-info clearfix">
                        <span class="direct-chat-name pull-left">{{Auth::user()->first_name}} {{Auth::user()->last_name}}</span>
                        <span class="direct-chat-timestamp pull-right">@{{message.created_at | moment }}</span>
                      </div>
                      <!-- /.direct-chat-info -->
                      <img class="direct-chat-img" :src="sender_profile_img" alt="Avatar" class="right userimage" style="width:40px;height: 40px" ><!-- /.direct-chat-img -->
                        <div class="direct-chat-text" :style="[message.att_type == 'img' ? {'padding': '0px' } : {} ]">
                           <p v-if = 'message.attachment'> 
                              <img v-if ="message.att_type == 'img' " :src='message.attachment' style="width: 100%; height: 100%;" data-enlargable>
                              <a v-else :href="message.attachment" target="_blank" :download="message.file_name">@{{message.file_name}}</a>
                           </p>
                           <p v-if = '!message.attachment' v-html='urlify(message.message)'></p>
                           <p>
                            <a href='javascript::void()'  class="talkDeleteMessage" :data-message-id="message.id" data-toggle="tooltip" title="Delete">&nbsp;&nbsp;<i class="fa  fa-trash-o"></i></a>
                          </p>
                          <a href="#" class="text-muted" title="Seen" v-if='index == messageobj.length - 1 && (message.is_seen || live_seen)'>
                               &#10004;&#10004;
                          </a>
                        </div>
                      <!-- /.direct-chat-text -->
                    </div>
                    <!-- /.direct-chat-msg -->

                    <!-- Message to the right -->
                    <div class="direct-chat-msg right" v-if='message.sender.id != authuser' v-bind:id='"message-"+message.id' >
                      <div class="direct-chat-info clearfix">
                        <span class="direct-chat-name pull-right">@{{message.sender.first_name}} @{{message.sender.last_name}}</span>
                        <span class="direct-chat-timestamp pull-left">@{{message.created_at | moment }}</span>
                      </div>
                      <!-- /.direct-chat-info -->
                      <img class="direct-chat-img" :src="rcv_profile_img" alt="Avatar" class="right userimage" style="width:40px;height: 40px" ><!-- /.direct-chat-img -->
                        <div class="direct-chat-text" :style="[message.att_type == 'img' ? {'padding': '0px' } : {} ]">
                           <p v-if = 'message.attachment'> 
                              <img v-if ="message.att_type == 'img' " :src='message.attachment' style="width: 100%; height: 100%;" data-enlargable>
                              <a v-else :href="message.attachment" target="_blank" :download="message.file_name">@{{message.file_name}}</a>
                           </p>
                           <p v-if = '!message.attachment' v-html='urlify(message.message)'></p>
                            <p>
                            <a href='javascript::void()'  class="talkDeleteMessage" :data-message-id="message.id" data-toggle="tooltip" title="Delete">&nbsp;&nbsp;<i class="fa  fa-trash-o"></i></a>
                          </p>
                        </div>
                      <!-- /.direct-chat-text -->
                    </div>
                  </div>
                   @endif
                   <div class="direct-chat-msg right" style="display: none;" id='userTyping'>
               <img class="direct-chat-img" :src="rcv_profile_img" alt="Avatar" class="right userimage" style="width:40px;height: 40px" >
                <div class="direct-chat-text">
                  <p><i>Typing.......</i></p>
                </div>
              </div> 

                </div>
               

                

                 <div v-if='messageobj.length == 0' >
                <div align="center">
                  <div class="img-responsive"> 
                    <img :src="rcv_profile_img" class="img-thumbnail" alt="Avatar" style="width:100%;border-radius: 50%;height: 100px;width: 100px;" >
                  </div>
                    <span style="margin: auto;"><h3>{{  $rcv_user->first_name }} {{  $rcv_user->last_name }}</h3></span>
                  </div>
                  <hr>
                  <div align="left">
                      <div class="alert alert-info" role="alert">
                          Type Message To start Conversation
                      </div>
                  </div>
                </div>
                <!-- /.direct-chat-msg -->
              </div>
              <!--/.direct-chat-messages-->

              <!-- Contacts are loaded here -->
              <div class="direct-chat-contacts" style="min-height: 76.8vh;">
                <ul class="contacts-list">
                    @foreach($threads as $inbox)
                    @if(!is_null($inbox->thread))
                  <li>
                    <a href="{{route('message.read', ['id'=>$inbox->withUser->id])}}">
                      <img class="contacts-list-img"  src="{{$inbox->withUser->avatar}}" style="height: 40px; width: 40px;" alt="avatar">

                      <div class="contacts-list-info">
                            <span class="contacts-list-name">
                              {{$inbox->withUser->first_name}}&nbsp;{{$inbox->withUser->last_name}}
                              <small class="contacts-list-date pull-right">{{ date('dS M', strtotime($inbox->thread->created_at)) }}</small>
                            </span>
                        <span class="contacts-list-msg">{{substr($inbox->thread->message, 0, 20)}}</span>
                        @if(auth()->user()->id == $inbox->thread->sender->id)
                            <i class="fa fa-reply"></i>
                        @endif
                      </div>
                      <!-- /.contacts-list-info -->
                    </a>
                  </li>
                  @endif
                   @endforeach
                  <!-- End Contact Item -->
                </ul>
                <!-- /.contatcts-list -->
              </div>
              <!-- /.direct-chat-pane -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
               <form method="post" id ='talkSendMessages'>
                <div class="input-group">
                  <textarea type="text" name="message-data" placeholder="Type Message ..." class="SeenMessage form-control resize-ta" data-user-id="{{$receiver}}"
              data-conversation-id="{{ count($messages) > 0 ?  $messages[0]->conversation_id : ''}}" required="" id="message-data" autofocus rows="1" ></textarea>
              <input type="hidden" name="_id" value="{{ $receiver }}">
                    <span class="input-group-btn">
                 
                        <label type="button" class="btn btn-default" for='attachment' title="Send Attachment"><i class="fa  fa-paperclip"></i>
                        <input type="file" name="" style="display: none;" id='attachment'>
                      </label>
                      </span>
                      <span class="input-group-btn">
                        <button type="submit" class="btn btn-primary" style="float: right;">{{ trans('/admin/chat/general.button.send_message') }}</button>

                        
                      </span>

                </div>
              </form>

            </div>
            <!-- /.box-footer-->
          </div>
          <!--/.direct-chat -->
        </div>
  @endif
</div>
 <span id='scrollAferSend'></span>
  @include('admin.talk.chatjs')

  <script type="text/javascript">
    $(function(){

// Dealing with Textarea Height
      function calcHeight(value) {
        let numberOfLineBreaks = (value.match(/\n/g) || []).length;
        // min-height + lines x line-height + padding + border
        let newHeight = 20 + numberOfLineBreaks * 20 + 12 + 2;
        return newHeight;
      }

      let textarea = document.querySelector(".resize-ta");
      textarea.addEventListener("keyup", () => {
        textarea.style.height = calcHeight(textarea.value) + "px";
      });

 // $('#remove-others').click(function(){
 //      alert("DONE");
 //      

 //    });

    });

  function makeFullView(){

  $('#first').attr('class','col-xs-12');
 }  
      
  </script>
@endsection