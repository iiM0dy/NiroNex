<div id="chat-container" class="lira-chat-scroll">
    <ul id="chat-history" class="lira-chat-list">
        @forelse ($messages as $msg)
            @php
                $isSelf = $msg->sender_id === auth()->id();
            @endphp

            <li class="lira-chat-item {{ $isSelf ? 'is-self' : 'is-admin' }} animate__animated animate__fadeInUp"
                style="--animate-duration: 0.28s;" data-id="{{ $msg->id }}">
                <div class="lira-chat-row">
                    <div class="lira-chat-avatar">
                        @if ($isSelf)
                            @if (auth()->user()->image && file_exists(public_path(auth()->user()->image)))
                                <img src="{{ asset(auth()->user()->image) }}" alt="User avatar">
                            @else
                                <img src="{{ asset('assets/images/default-pfp.webp') }}" alt="User avatar">
                            @endif
                        @else
                            <span class="lira-chat-admin-icon">
                                <i class="fas fa-headset"></i>
                            </span>
                        @endif
                    </div>

                    <div class="lira-chat-content">
                        <div class="lira-chat-bubble">
                            {{ $msg->body }}
                        </div>
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
        .lira-chat-scroll {
            flex: 1 1 auto;
            min-height: 0;
            overflow-y: auto;
            padding: 22px;
            background: rgba(255, 255, 255, 0.01);
            scroll-behavior: smooth;
        }

        .lira-chat-list {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .lira-chat-item {
            display: flex;
            width: 100%;
        }

        .lira-chat-item.is-self {
            justify-content: flex-start;
        }

        .lira-chat-item.is-admin {
            justify-content: flex-end;
        }

        .lira-chat-row {
            display: flex;
            align-items: flex-end;
            gap: 10px;
            max-width: min(78%, 720px);
        }

        .lira-chat-item.is-admin .lira-chat-row {
            flex-direction: row-reverse;
        }

        .lira-chat-avatar {
            width: 34px;
            height: 34px;
            border-radius: 12px;
            overflow: hidden;
            flex: 0 0 auto;
            border: 1px solid rgba(255, 255, 255, 0.08);
            background: rgba(255, 255, 255, 0.04);
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .lira-chat-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .lira-chat-item.is-self .lira-chat-avatar {
            background: rgba(0, 230, 167, 0.14);
            border-color: rgba(0, 230, 167, 0.18);
        }

        .lira-chat-admin-icon {
            width: 100%;
            height: 100%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: var(--lira-accent);
            font-size: 13px;
        }

        .lira-chat-content {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .lira-chat-item.is-self .lira-chat-content {
            align-items: flex-start;
        }

        .lira-chat-item.is-admin .lira-chat-content {
            align-items: flex-end;
        }

        .lira-chat-bubble {
            padding: 12px 14px;
            border-radius: 18px;
            font-size: 13px;
            line-height: 1.9;
            white-space: pre-wrap;
            word-break: break-word;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.12);
        }

        .lira-chat-item.is-self .lira-chat-bubble {
            background: var(--lira-accent);
            color: #0d1117;
            border-bottom-right-radius: 6px;
            font-weight: 700;
        }

        .lira-chat-item.is-admin .lira-chat-bubble {
            background: var(--lira-surface-2);
            color: var(--lira-text);
            border: 1px solid var(--lira-border);
            border-bottom-left-radius: 6px;
        }

        .lira-chat-time {
            color: var(--lira-text-muted);
            font-size: 10px;
            padding: 0 6px;
        }

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
        (function () {
            const userId = {{ auth()->id() }};
            const userAvatar = `{{ auth()->user()->image && file_exists(public_path(auth()->user()->image)) ? asset(auth()->user()->image) : asset('assets/images/default-pfp.webp') }}`;

            const processedMessageIds = new Set([
                @foreach($messages as $msg)
                    {{ $msg->id }},
                @endforeach
            ]);

            let lastMessageId = {{ $messages->last()?->id ?? 0 }};

            function escapeHtml(text) {
                return String(text)
                    .replace(/&/g, "&amp;")
                    .replace(/</g, "&lt;")
                    .replace(/>/g, "&gt;")
                    .replace(/"/g, "&quot;")
                    .replace(/'/g, "&#039;");
            }

            function renderMessage(msg) {
                const isUser = Number(msg.sender_id) === Number(userId);
                const time = escapeHtml(msg.time_formatted || 'الآن');
                const body = escapeHtml(msg.body || '');

                if (isUser) {
                    return `
                        <li class="lira-chat-item is-self animate__animated animate__fadeInUp" style="--animate-duration: 0.28s;" data-id="${msg.id}">
                            <div class="lira-chat-row">
                                <div class="lira-chat-avatar">
                                    <img src="${userAvatar}" alt="User avatar">
                                </div>
                                <div class="lira-chat-content">
                                    <div class="lira-chat-bubble">${body}</div>
                                    <small class="lira-chat-time">${time}</small>
                                </div>
                            </div>
                        </li>
                    `;
                }

                return `
                    <li class="lira-chat-item is-admin animate__animated animate__fadeInUp" style="--animate-duration: 0.28s;" data-id="${msg.id}">
                        <div class="lira-chat-row">
                            <div class="lira-chat-avatar">
                                <span class="lira-chat-admin-icon">
                                    <i class="fas fa-headset"></i>
                                </span>
                            </div>
                            <div class="lira-chat-content">
                                <div class="lira-chat-bubble">${body}</div>
                                <small class="lira-chat-time">${time}</small>
                            </div>
                        </div>
                    </li>
                `;
            }

            function scrollToBottom() {
                const container = document.getElementById('chat-container');
                if (!container) return;
                container.scrollTop = container.scrollHeight;
            }

            function appendMessage(msg) {
                if (processedMessageIds.has(msg.id)) return;

                const chatHistory = $('#chat-history');
                $('#empty-state').remove();
                chatHistory.append(renderMessage(msg));

                processedMessageIds.add(msg.id);
                lastMessageId = Math.max(lastMessageId, Number(msg.id) || 0);
                scrollToBottom();
            }

            function fetchNewMessages() {
                $.get('{{ route('site.api.messages.fetch') }}', {
                    after_id: lastMessageId
                }, function (data) {
                    if (data.messages && data.messages.length > 0) {
                        data.messages.forEach(appendMessage);
                    }
                });
            }

            $(document).ready(function () {
                scrollToBottom();

                $('#message-input').off('keypress.liraChat').on('keypress.liraChat', function (e) {
                    if (e.which === 13 && !e.shiftKey) {
                        e.preventDefault();
                        $('#send-message').trigger('click');
                    }
                });

                $('#send-message').off('click.liraChat').on('click.liraChat', function (e) {
                    e.preventDefault();

                    const btn = $(this);
                    const input = $('#message-input');
                    const body = input.val().trim();

                    if (!body) return;

                    const originalHtml = btn.html();
                    btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');

                    $.post('{{ route('site.api.messages.send') }}', {
                        _token: '{{ csrf_token() }}',
                        body: body
                    })
                    .done(function (response) {
                        if (response.message) {
                            appendMessage(response.message);
                            input.val('');
                        }
                    })
                    .fail(function () {
                        if (window.showNotification) {
                            window.showNotification('تعذر إرسال الرسالة حالياً. حاول مرة أخرى.', 'error');
                        } else {
                            alert('تعذر إرسال الرسالة حالياً. حاول مرة أخرى.');
                        }
                    })
                    .always(function () {
                        btn.prop('disabled', false).html(originalHtml);
                    });
                });

                if (window.liraChatPoller) {
                    clearInterval(window.liraChatPoller);
                }

                window.liraChatPoller = setInterval(fetchNewMessages, 5000);
            });
        })();
    </script>
@endpush

