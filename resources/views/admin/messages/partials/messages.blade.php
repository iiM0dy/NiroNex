<!-- Chat: body -->
<div id="chat-container" class="lira-chat-scroll">
    <ul id="chat-history" class="lira-chat-list">
        @forelse ($messages as $msg)
            @php
                $isSelf = $msg->sender_id === auth()->id();
            @endphp

            <li class="lira-chat-item {{ $isSelf ? 'is-self' : 'is-other' }} animate__animated animate__fadeInUp"
                style="--animate-duration: 0.28s;" data-id="{{ $msg->id }}" id="msg-{{ $msg->id }}">
                <div class="lira-chat-row">
                    <div class="lira-chat-avatar {{ $isSelf ? 'is-admin-avatar' : 'is-user-avatar' }}">
                        @if ($isSelf)
                            {{-- Admin avatar --}}
                            @if (auth()->user()->image && file_exists(public_path(auth()->user()->image)))
                                <img src="{{ asset(auth()->user()->image) }}" alt="Admin">
                            @else
                                <span class="lira-chat-avatar-icon"><i class="fas fa-headset"></i></span>
                            @endif
                        @else
                            {{-- User avatar - show their initial or photo --}}
                            @if ($user->image && file_exists(public_path($user->image)))
                                <img src="{{ asset($user->image) }}" alt="{{ $user->full_name }}">
                            @else
                                <span class="lira-chat-avatar-initial">{{ mb_substr($user->full_name, 0, 1) }}</span>
                            @endif
                        @endif
                    </div>

                    <div class="lira-chat-content">
                        <div class="lira-chat-bubble">@if($msg->title)<strong class="lira-chat-bubble-title">{{ $msg->title }}</strong>@endif{{ trim($msg->body) }}</div>
                        <small class="lira-chat-time">{{ formatDate($msg->created_at) }}</small>
                    </div>
                </div>
            </li>
        @empty
            <li id="empty-state" class="lira-chat-empty">
                <div class="lira-chat-empty-icon">
                    <i class="fas fa-comments"></i>
                </div>
                <strong>لا توجد رسائل سابقة</strong>
                <span>ابدأ المحادثة الآن وسيظهر سجل الرسائل هنا.</span>
            </li>
        @endforelse
    </ul>
</div>

@push('custom_styles')
    <style>
        /* ─── Scroll Area ─── */
        .lira-chat-scroll {
            flex: 1 1 auto;
            min-height: 0;
            overflow-y: auto;
            padding: 24px;
            background:
                radial-gradient(circle at top right, rgba(0, 230, 167, 0.03), transparent 20%),
                rgba(255, 255, 255, 0.01);
            scroll-behavior: smooth;
        }

        .lira-chat-list {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        /* ─── Chat Item Layout ─── */
        .lira-chat-item {
            display: flex;
            width: 100%;
        }

        /* LTR Layout */
        html[dir="ltr"] .lira-chat-item.is-self {
            justify-content: flex-end; /* Right side */
        }
        html[dir="ltr"] .lira-chat-item.is-other {
            justify-content: flex-start; /* Left side */
        }

        /* RTL Layout */
        html[dir="rtl"] .lira-chat-item.is-self,
        [dir="rtl"] .lira-chat-item.is-self {
            justify-content: flex-start; /* Right side in RTL */
        }
        html[dir="rtl"] .lira-chat-item.is-other,
        [dir="rtl"] .lira-chat-item.is-other {
            justify-content: flex-end; /* Left side in RTL */
        }

        .lira-chat-row {
            display: flex;
            align-items: flex-end;
            gap: 10px;
            max-width: min(78%, 720px);
        }

        html[dir="ltr"] .lira-chat-item.is-self .lira-chat-row,
        [dir="ltr"] .lira-chat-item.is-self .lira-chat-row {
            flex-direction: row-reverse;
        }
        
        html[dir="rtl"] .lira-chat-item.is-other .lira-chat-row,
        [dir="rtl"] .lira-chat-item.is-other .lira-chat-row {
            flex-direction: row-reverse;
        }

        /* ─── Avatar ─── */
        .lira-chat-avatar {
            width: 34px;
            height: 34px;
            border-radius: 12px;
            overflow: hidden;
            flex: 0 0 auto;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .lira-chat-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .lira-chat-avatar.is-admin-avatar {
            background: rgba(0, 230, 167, 0.14);
            border: 1px solid rgba(0, 230, 167, 0.22);
        }

        .lira-chat-avatar.is-user-avatar {
            background: var(--lira-surface-2);
            border: 1px solid var(--lira-border);
        }

        .lira-chat-avatar-icon {
            width: 100%;
            height: 100%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: var(--lira-accent);
            font-size: 13px;
        }

        .lira-chat-avatar-initial {
            width: 100%;
            height: 100%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: var(--lira-text-soft);
            font-size: 13px;
            font-weight: 800;
        }

        /* ─── Content ─── */
        .lira-chat-content {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        /* LTR Layout */
        html[dir="ltr"] .lira-chat-item.is-self .lira-chat-content {
            align-items: flex-end; /* Right */
        }
        html[dir="ltr"] .lira-chat-item.is-other .lira-chat-content {
            align-items: flex-start; /* Left */
        }

        /* RTL Layout */
        html[dir="rtl"] .lira-chat-item.is-self .lira-chat-content,
        [dir="rtl"] .lira-chat-item.is-self .lira-chat-content {
            align-items: flex-start; /* Right in RTL */
        }
        html[dir="rtl"] .lira-chat-item.is-other .lira-chat-content,
        [dir="rtl"] .lira-chat-item.is-other .lira-chat-content {
            align-items: flex-end; /* Left in RTL */
        }

        /* ─── Bubble ─── */
        .lira-chat-bubble {
            padding: 12px 16px;
            border-radius: 18px;
            font-size: 13.5px;
            line-height: 1.9;
            white-space: pre-wrap;
            word-break: break-word;
        }

        .lira-chat-item.is-self .lira-chat-bubble {
            background: linear-gradient(180deg, var(--lira-accent-strong), var(--lira-accent));
            color: #0f0c06;
            border-bottom-right-radius: 6px;
            font-weight: 700;
            box-shadow: 0 6px 22px rgba(0, 230, 167, 0.18);
        }

        .lira-chat-item.is-other .lira-chat-bubble {
            background: var(--lira-surface-2);
            color: var(--lira-text);
            border: 1px solid var(--lira-border);
            border-bottom-left-radius: 6px;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.15);
        }

        .lira-chat-bubble-title {
            display: block;
            margin-bottom: 4px;
            padding-bottom: 4px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            font-size: 11px;
            opacity: 0.75;
        }

        /* ─── Time ─── */
        .lira-chat-time {
            color: var(--lira-text-muted);
            font-size: 10px;
            padding: 0 6px;
        }

        /* ─── Empty State ─── */
        .lira-chat-empty {
            min-height: 320px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 10px;
            text-align: center;
            color: var(--lira-text-muted);
        }

        .lira-chat-empty-icon {
            width: 62px;
            height: 62px;
            border-radius: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(0, 230, 167, 0.08);
            color: var(--lira-accent);
            font-size: 24px;
            margin-bottom: 6px;
        }

        .lira-chat-empty strong {
            color: var(--lira-text);
            font-size: 15px;
        }

        .lira-chat-empty span {
            font-size: 13px;
            max-width: 320px;
            line-height: 1.8;
        }

        @media (max-width: 767.98px) {
            .lira-chat-scroll {
                padding: 16px;
            }

            .lira-chat-row {
                max-width: 92%;
            }
        }
    </style>
@endpush

@push('custom_scripts')
    <script>
        const authUserId = {{ auth()->id() }};
        const targetUserId = {{ $user->id }};
        let lastMessageId = {{ $messages->last()?->id ?? 0 }};
        const userInitial = `{{ mb_substr($user->full_name, 0, 1) }}`;

        const processedIds = new Set([
            @foreach($messages as $msg)
                {{ $msg->id }},
            @endforeach
        ]);

        function fetchNewMessages() {
            $.get('{{ route('admin.api.messages.fetch') }}', {
                after_id: lastMessageId,
                user_id: targetUserId,
            }, function (data) {
                if (data.messages && data.messages.length > 0) {
                    $('#empty-state').remove();
                    data.messages.forEach(msg => {
                        if (!processedIds.has(msg.id)) {
                            $('#chat-history').append(renderMessage(msg));
                            processedIds.add(msg.id);
                            lastMessageId = Math.max(lastMessageId, Number(msg.id));
                        }
                    });
                    scrollToBottom();
                }
            });
        }

        function renderMessage(msg) {
            const isSelf = Number(msg.sender_id) === authUserId;
            const time = escapeHtml(msg.time_formatted || 'الآن');
            const body = escapeHtml(msg.body || '');
            const title = msg.title ? escapeHtml(msg.title) : '';
            const adminImg = `{{ auth()->user()->image && file_exists(public_path(auth()->user()->image)) ? asset(auth()->user()->image) : '' }}`;
            const userImg = `{{ $user->image && file_exists(public_path($user->image)) ? asset($user->image) : '' }}`;

            let avatarHtml;
            if (isSelf) {
                avatarHtml = adminImg
                    ? `<img src="${adminImg}" alt="Admin">`
                    : `<span class="lira-chat-avatar-icon"><i class="fas fa-headset"></i></span>`;
            } else {
                avatarHtml = userImg
                    ? `<img src="${userImg}" alt="User">`
                    : `<span class="lira-chat-avatar-initial">${userInitial}</span>`;
            }

            const avatarClass = isSelf ? 'is-admin-avatar' : 'is-user-avatar';

            return `
                <li class="lira-chat-item ${isSelf ? 'is-self' : 'is-other'} animate__animated animate__fadeInUp" 
                    style="--animate-duration: 0.28s;" data-id="${msg.id}" id="msg-${msg.id}">
                    <div class="lira-chat-row">
                        <div class="lira-chat-avatar ${avatarClass}">${avatarHtml}</div>
                        <div class="lira-chat-content">
                            <div class="lira-chat-bubble">${title ? `<strong class="lira-chat-bubble-title">${title}</strong>` : ''}${body.trim()}</div>
                            <small class="lira-chat-time">${time}</small>
                        </div>
                    </div>
                </li>
            `;
        }

        function scrollToBottom() {
            const container = document.getElementById('chat-container');
            if (container) {
                container.scrollTop = container.scrollHeight;
            }
        }

        $(document).ready(function () {
            scrollToBottom();

            $('#message-input').on('keypress', function (e) {
                if (e.which === 13 && !e.shiftKey) {
                    e.preventDefault();
                    $('#send-message').click();
                }
            });

            $('#send-message').on('click', function (e) {
                e.preventDefault();
                const btn = $(this);
                const input = $('#message-input');
                const body = input.val().trim();
                
                if (!body) return;

                const originalHtml = btn.html();
                btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');

                $.post('{{ route('admin.api.messages.send') }}', {
                    _token: '{{ csrf_token() }}',
                    body: body,
                    user_id: targetUserId
                })
                .done(function (response) {
                    if (response.message && !processedIds.has(response.message.id)) {
                        $('#empty-state').remove();
                        $('#chat-history').append(renderMessage(response.message));
                        processedIds.add(response.message.id);
                        lastMessageId = Math.max(lastMessageId, Number(response.message.id));
                        input.val('');
                        scrollToBottom();
                    }
                })
                .always(function () {
                    btn.prop('disabled', false).html(originalHtml);
                });
            });

            setInterval(fetchNewMessages, 5000);
        });

        function escapeHtml(text) {
            return text
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
        }
    </script>
@endpush

