@extends('layouts.app')

@section('title', 'Chat - Marahin Aja')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="glass rounded-xl shadow-apple">
        <div class="border-b" style="border-color: var(--border-color)">
            <div class="p-4 flex justify-between items-center">
                <div>
                    @if($room->user2_id)
                        <span class="uppercase font-bold flex items-center">
                            <span class="w-2.5 h-2.5 bg-green-500 rounded-full mr-2"></span>
                            @if($user->id == $room->user1_id)
                                {{ $room->user2->name }}
                            @else
                                {{ $room->user1->name }}
                            @endif
                        </span>
                    @else
                        <span class="text-ye-accent uppercase text-sm flex items-center">
                            <span class="w-2.5 h-2.5 bg-ye-accent rounded-full animate-pulse mr-2"></span>
                            MENUNGGU...
                        </span>
                    @endif
                </div>
                
                <div class="flex items-center space-x-2">
                    @if($room->type == 'marah')
                        <span class="uppercase text-xs px-3 py-1.5 bg-ye-accent text-white rounded-full shadow-sm">MARAH</span>
                    @elseif($room->type == 'dimarahin')
                        <span class="uppercase text-xs px-3 py-1.5 bg-white text-ye-bg rounded-full shadow-sm">DENGAR</span>
                    @else
                        <span class="uppercase text-xs px-3 py-1.5 bg-ye-accent text-white rounded-full shadow-sm">MARAH</span>
                        <span class="uppercase text-xs px-3 py-1.5 bg-white text-ye-bg rounded-full shadow-sm">DENGAR</span>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="p-4">
            <div class="chat-container h-[400px] relative mb-4 backdrop-blur-sm rounded-xl shadow-apple overflow-hidden border">
                <div id="chat-window" class="absolute inset-0 overflow-y-scroll p-4">
                    @foreach($messages as $message)
                        <div class="message {{ $message->user_id == $user->id ? 'message-sender' : 'message-receiver' }}">
                            <div class="text-xs mb-1">
                                {{ $message->user->name }} • {{ \Carbon\Carbon::parse($message->created_at)->format('H:i') }}
                            </div>
                            <div class="message-text break-words">
                                {{ $message->message }}
                            </div>
                        </div>
                    @endforeach
                </div>
                <button id="scroll-to-bottom-btn" class="absolute bottom-4 right-4 glass p-2 rounded-full shadow-apple opacity-0 transition-opacity duration-300 z-10">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </button>
            </div>
            
            <form id="message-form" class="mb-4">
                <div class="flex gap-2">
                    <div class="flex-1 relative">
                        <input type="text" id="message-input" class="ye-input pr-12 rounded-full" placeholder="KETIK PESAN...">
                    </div>
                    <button type="submit" class="ye-btn-primary py-2 px-5 rounded-full flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="22" y1="2" x2="11" y2="13"></line>
                            <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                        </svg>
                    </button>
                </div>
            </form>
            
            <div class="text-center">
                <form action="{{ route('chat.close', $room->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="text-xs uppercase tracking-widest hover:text-ye-accent transition-colors px-4 py-1.5 rounded-full glass hover-scale">
                        TUTUP
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Simple scrollbar */
    #chat-window::-webkit-scrollbar {
        width: 6px;
    }
    
    #chat-window::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.05);
    }
    
    #chat-window::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 10px;
    }
    
    #chat-window::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 0, 0, 0.4);
    }
    
    /* Ensure chat window is scrollable */
    .chat-container {
        display: flex;
        flex-direction: column;
        border-color: var(--border-color);
        background-color: rgba(0, 0, 0, 0.1);
    }
    
    html[data-theme='light'] .chat-container {
        background-color: rgba(0, 0, 0, 0.03);
    }
    
    .message {
        clear: both;
    }
    
    /* Dark/Light mode specific chat styles */
    html[data-theme='dark'] {
        --message-text-color: rgba(255, 255, 255, 0.9);
        --message-sender-bg: #ff0000;
        --message-sender-text: white;
        --message-sender-meta: rgba(255, 255, 255, 0.8);
    }
    
    html[data-theme='light'] {
        --message-text-color: rgba(0, 0, 0, 0.9);
        --message-sender-bg: #ff0000;
        --message-sender-text: white;
        --message-sender-meta: rgba(255, 255, 255, 0.8);
    }
    
    .message-sender {
        @apply text-right ml-[20%] mb-4 p-3 rounded-2xl rounded-tr-sm shadow-sm;
        background-color: var(--message-sender-bg);
        color: var(--message-sender-text);
    }
    
    .message-receiver {
        text-shadow: none;
    }
    
    .message-sender .text-xs {
        color: var(--message-sender-meta) !important;
    }
    
    .message-receiver .text-xs {
        color: var(--message-text-color) !important;
        opacity: 0.8;
    }
</style>
@endpush

@push('scripts')
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script>
    $(document).ready(function() {
        // Initial scroll to bottom
        scrollToBottom();
        
        // Timestamp of last retrieved message
        let lastMessageTimestamp = {{ $messages->count() > 0 ? $messages->last()->created_at->timestamp : 0 }};
        
        // Scroll to bottom button visibility
        const chatWindow = document.getElementById('chat-window');
        const scrollButton = document.getElementById('scroll-to-bottom-btn');
        
        chatWindow.addEventListener('scroll', function() {
            const isScrolledUp = chatWindow.scrollTop < (chatWindow.scrollHeight - chatWindow.clientHeight - 100);
            if (isScrolledUp) {
                scrollButton.style.opacity = '1';
            } else {
                scrollButton.style.opacity = '0';
            }
        });
        
        scrollButton.addEventListener('click', function() {
            scrollToBottom();
        });
        
        // Get new messages via polling
        function getNewMessages() {
            $.ajax({
                url: '{{ route('chat.messages', $room->id) }}',
                type: 'GET',
                data: {
                    last_timestamp: lastMessageTimestamp
                },
                success: function(response) {
                    console.log('Messages retrieved:', response);
                    if (response.success && response.messages && response.messages.length > 0) {
                        // Add new messages from other users
                        response.messages.forEach(function(message) {
                            console.log('Processing message:', message);
                            if (message.user_id != {{ $user->id }}) {
                                const time = formatTime(new Date(message.created_at));
                                addMessage(message.message, message.user, time);
                                scrollToBottom();
                            }
                        });
                        
                        // Update timestamp after processing messages
                        const lastMessage = response.messages[response.messages.length - 1];
                        lastMessageTimestamp = Math.floor(new Date(lastMessage.created_at).getTime() / 1000);
                    }
                },
                complete: function() {
                    // Schedule next poll
                    setTimeout(getNewMessages, 3000);
                }
            });
        }
        
        // Start polling for new messages
        getNewMessages();
        
        // Handle message form submission
        $('#message-form').on('submit', function(e) {
            e.preventDefault();
            
            const messageInput = $('#message-input');
            const message = messageInput.val().trim();
            if (!message) return;
            
            // Clear input immediately
            messageInput.val('');
            
            // Disable input and button while sending
            messageInput.prop('disabled', true);
            $(this).find('button').prop('disabled', true);
            
            // Add message to chat window immediately
            const currentUser = {
                id: {{ $user->id }},
                name: '{{ $user->name }}'
            };
            const time = formatTime(new Date());
            addMessage(message, currentUser, time);
            scrollToBottom();
            
            $.ajax({
                url: '{{ route('chat.send', $room->id) }}',
                type: 'POST',
                data: {
                    message: message,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.log('Message sent successfully:', response);
                    if (response.success && response.message) {
                        // Update last message timestamp
                        lastMessageTimestamp = Math.floor(new Date(response.message.created_at).getTime() / 1000);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error sending message:', {xhr, status, error});
                    alert('Failed to send message. Please try again.');
                    // Remove the message if sending failed
                    $('#chat-window .message:last').remove();
                },
                complete: function() {
                    // Re-enable input and button
                    messageInput.prop('disabled', false).focus();
                    $('#message-form').find('button').prop('disabled', false);
                }
            });
        });

        // Handle enter key
        $('#message-input').on('keypress', function(e) {
            if (e.which == 13) {
                e.preventDefault();
                $('#message-form').submit();
            }
        });
    });

    function addMessage(message, user, time) {
        console.log('Adding message:', { message, user, time }); // Debug log
        const isCurrentUser = user.id == {{ $user->id }};
        const messageClass = isCurrentUser ? 'message-sender' : 'message-receiver';
        
        const messageHtml = `
            <div class="message ${messageClass}">
                <div class="text-xs mb-1">
                    ${user.name} • ${time}
                </div>
                <div class="message-text break-words">
                    ${message}
                </div>
            </div>
        `;
        
        $('#chat-window').append(messageHtml);
    }

    function scrollToBottom() {
        const chatWindow = document.getElementById('chat-window');
        chatWindow.scrollTop = chatWindow.scrollHeight;
    }

    function formatTime(date) {
        return date.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
    }
</script>
@endpush 