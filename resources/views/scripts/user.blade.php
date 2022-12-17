@include('scripts.script')
<script>
    $(document).ready(function(){

        setInterval(function(){
            getUserList();
        },1000);

        function getUserList(){
            $.ajax({
                url:"{{ url('/fetch-user-by-ajax') }}",
                method: "GET",
                success:function(data){
                    if(data.length > 0){
                        let userHtml = "";
                            let fetchUser = "{{ $firstUser->id }}";

                            for(let i = 0; i < data.length; i++){
                                let user = data[i];

                                userHtml += '<a href="{{ url('/') . '?user='}} '+ btoa(user.id) +' ">';
                                    let activeClass = '';
                                    if(user.id === Number(fetchUser)){
                                        activeClass = 'bg-gradient-to-r from-red-100 to-transparent border-l-2 border-red-500';
                                    }
                                    userHtml += '<div class="relative flex flex-row items-center p-4 cursor-pointer change-chat '+activeClass+' " data-user-id="'+user.id+'">';

                                        userHtml += '<div class="flex items-center justify-center h-10 w-10 rounded-full bg-pink-500 text-pink-300 font-bold flex-shrink-0">';
                                            userHtml += user.name.substring(0,1);
                                        userHtml += '</div>';

                                        userHtml += '<div class="flex flex-col flex-grow ml-3">';
                                            userHtml += '<div class="text-sm font-medium">'+user.name+ '</div>';
                                        userHtml += '</div>';

                                        userHtml += '<div class="flex-shrink-0 ml-2 self-end mb-1">';
                                            if(user.total_unread > 0){
                                                userHtml += '<span class="flex items-center justify-center h-5 w-5 bg-red-500 text-white text-xs rounded-full">'+user.total_unread+'</span>';
                                            }else{
                                                userHtml += '<span class="flex items-center justify-center h-5 w-5 bg-white-500 text-white text-xs rounded-full"></span>';
                                            }
                                        userHtml += '</div>';

                                    userHtml += '</div>';
                                userHtml += '</a>';
                            }

                        $('.append-user').html(userHtml);
                    }
                }
            })
        }
    });
</script>
