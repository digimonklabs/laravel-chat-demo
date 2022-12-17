@include('scripts.script')
<script>
    $(document).ready(function(){
       $('.send-message-btn').on('click',function(){
            let message = $('.message-text-box').val();
            let receiverId = $('.user_receiver_id').val();
            if(message !== ""){
                sendMessage(message,receiverId);
            }
       }) ;

        $('.message-text-box').on('keypress',function(e){
           let message = $(this).val();
           let key = e.which;
            let receiverId = $('.user_receiver_id').val();
           if(key === 13 && message !== ""){
               sendMessage(message,receiverId);
           }
        });


       function sendMessage(message,receiverId){
           $.ajax({
               url: "{{ route('sendMessage') }}",
               method: "POST",
               data:{
                   "_token": "{{ csrf_token() }}",
                   "message": message,
                   "receiver_id": receiverId
               },
               success:function(data){
                    if(data.status === "success"){
                        $('.message-text-box').val("");
                        fetchMessages();
                    }
               },
               error:function(err){
                   console.log(err);
               }
           });
       }

       setInterval(function(){
           fetchMessages();
       },2000);

       function fetchMessages(){
           let receiverId = $('.user_receiver_id').val();
           $.ajax({
               url:"{{ url('/fetch-user-messages-by-ajax?receiver_id=') }}" + receiverId,
               method:"GET",
               success:function(data){
                   if(data.length > 0){
                        let messageHtml = "";
                        let userId = "{{ auth()->user()->id }}";

                        messageHtml += '<div class="grid grid-cols-12 gap-y-2">';
                        for(let i = 0; i < data.length; i++){
                            let message = data[i];

                            if(message.sender_id === Number(userId)){

                                messageHtml += '<div class="col-start-6 col-end-13 p-3 rounded-lg">';
                                messageHtml += '<div class="flex items-center justify-start flex-row-reverse">';
                                messageHtml += '<div class="flex items-center justify-center h-10 w-10 rounded-full bg-indigo-500 flex-shrink-0">'
                                messageHtml += message.sender_name.substring(0,1);
                                messageHtml += '</div>';

                                messageHtml += '<div class="relative mr-3 text-sm bg-indigo-100 py-2 px-4 shadow rounded-xl" >';
                                messageHtml += '<div>'+ message.message +'</div>';
                                messageHtml += '<div class="absolute text-xs bottom-0 right-0 -mb-5 mr-2 text-gray-500 cursor-pointer on-delete-click" data-message-id='+message.mc_id+'>';
                                messageHtml += 'delete?';
                                messageHtml += '</div>';
                                messageHtml += '</div>';

                                messageHtml += '</div>';
                                messageHtml += '</div>';
                            }else{

                                messageHtml += '<div class="col-start-1 col-end-8 p-3 rounded-lg">';
                                messageHtml += '<div class="flex flex-row items-center">';

                                messageHtml += '<div class="flex items-center justify-center h-10 w-10 rounded-full bg-indigo-500 flex-shrink-0">'
                                messageHtml +=  message.sender_name.substring(0,1);
                                messageHtml += '</div>';

                                messageHtml += '<div class="relative ml-3 text-sm bg-white py-2 px-4 shadow rounded-xl" >';
                                messageHtml += '<div>'+message.message+'</div>';
                                messageHtml += '</div>';

                                messageHtml += '</div>';
                                messageHtml += '</div>';
                            }
                        }
                        messageHtml += '</div>';

                        $('.append-message-by-ajax').html(messageHtml);
                   }
               }
           })
       }
    });

    $(document).on('click','.on-delete-click',function(){
        let messageId = $(this).data('message-id');
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this message!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {

                    $.ajax({
                        url:"{{ route('delete') }}",
                        method: "POST",
                        data:{
                            "_token": "{{ csrf_token() }}",
                            "message_id": messageId
                        },
                        success:function(data){
                            if(data){
                                swal("Your Message is delete.", {
                                    icon: "success",
                                });
                            }else{
                                swal("Something went wrong while deleting message,Please try again or later.", {
                                    icon: "error",
                                });
                            }
                        }
                    })


                }
            });
    });

</script>
