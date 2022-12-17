<x-app-layout>


    <div class="flex flex-row h-screen antialiased text-gray-800">
        <div class="flex flex-row w-96 flex-shrink-0 bg-gray-100 p-4">
            <div class="flex flex-col w-full h-full pl-4 pr-4 py-4 -mr-4">
                <div class="flex flex-row items-center">
                    <div class="flex flex-row items-center">
                        <div class="text-xl font-semibold">Messages</div>
                    </div>
                </div>

                <div class="mt-2">
                    <div class="flex flex-col -mx-4 append-user">

                        @foreach($users as $key => $user)
                            <a href="{{ url('/') . '?user=' . base64_encode($user->id) }}">
                            <div
                                class="relative flex flex-row items-center p-4 cursor-pointer change-chat {{ $firstUser->id == $user->id ? 'bg-gradient-to-r from-red-100 to-transparent border-l-2 border-red-500' : "" }} "
                                data-user-id="{{ $user->id }}"
                            >

                                <div class="flex items-center justify-center h-10 w-10 rounded-full bg-pink-500 text-pink-300 font-bold flex-shrink-0">
                                    {{ substr($user->name,0,1) }}
                                </div>
                                <div class="flex flex-col flex-grow ml-3">
                                    <div class="text-sm font-medium">{{ $user->name }}</div>
                                </div>
                                <div class="flex-shrink-0 ml-2 self-end mb-1">
                                    @if($user->total_unread > 0)
                                    <span class="flex items-center justify-center h-5 w-5 bg-red-500 text-white text-xs rounded-full">{{ $user->total_unread }}</span>
                                    @else
                                        <span class="flex items-center justify-center h-5 w-5 bg-white-500 text-white text-xs rounded-full"></span>
                                    @endif
                                </div>

                            </div>
                            </a>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
        <div class="flex flex-col h-full w-full bg-white px-4 py-6">
            <div class="flex flex-row items-center py-4 px-6 rounded-2xl shadow">
                <div class="flex items-center justify-center h-10 w-10 rounded-full bg-pink-500 text-pink-100">
                    {{ substr($firstUser->name,0,1) }}
                </div>
                <div class="flex flex-col ml-3">
                    <input type="hidden" class="user_receiver_id" name="receiver_id" value="{{ $firstUser->id }}">
                    <div class="font-semibold text-sm">{{ $firstUser->name }}</div>
                    <div class="text-xs text-gray-500">Active</div>
                </div>

            </div>
            <div class="h-full overflow-hidden py-4">
                <div class="h-full overflow-y-auto append-message-by-ajax">
                    <div class="grid grid-cols-12 gap-y-2">

                        @foreach($userMessageList as $message)
                            @if($message->sender_id == auth()->user()->id)
                                <div class="col-start-6 col-end-13 p-3 rounded-lg">
                                    <div class="flex items-center justify-start flex-row-reverse">
                                        <div
                                            class="flex items-center justify-center h-10 w-10 rounded-full bg-indigo-500 flex-shrink-0"
                                        >
                                            {{ substr($message->sender_name,0,1) }}
                                        </div>
                                        <div
                                            class="relative mr-3 text-sm bg-indigo-100 py-2 px-4 shadow rounded-xl"
                                        >
                                            <div>{{ $message->message }}</div>
                                            <div
                                                class="absolute text-xs bottom-0 right-0 -mb-5 mr-2 text-gray-500 cursor-pointer on-delete-click"
                                                data-message-id="{{ $message->mc_id }}"
                                            >
                                                delete?
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @else
                                <div class="col-start-1 col-end-8 p-3 rounded-lg">
                                    <div class="flex flex-row items-center">
                                        <div
                                            class="flex items-center justify-center h-10 w-10 rounded-full bg-indigo-500 flex-shrink-0"
                                        >
                                            {{ substr($message->sender_name,0,1) }}
                                        </div>
                                        <div
                                            class="relative ml-3 text-sm bg-white py-2 px-4 shadow rounded-xl"
                                        >
                                            <div>{{ $message->message }}</div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="flex flex-row items-center">
                <div class="flex flex-row items-center w-full border rounded-3xl h-12 px-2">

                    <div class="w-full">
                        <input type="text" class="border border-transparent w-full focus:outline-none text-sm h-10 flex items-center message-text-box" placeholder="Type your message....">
                    </div>
                </div>
                <div class="ml-6">
                    <button class="flex items-center justify-center h-10 w-10 rounded-full bg-gray-200 hover:bg-gray-300 text-indigo-800 text-white send-message-btn">
                        <svg class="w-5 h-5 transform rotate-90 -mr-px"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24"
                             xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @include('scripts.message')
    @include('scripts.user')
</x-app-layout>
