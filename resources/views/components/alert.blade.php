<div
    x-data="{
        show: false,
        message: '',
        type: 'success',
        open(message, type = 'success') {
            this.message = message;
            this.type = type;
            this.show = true;
            setTimeout(() => this.show = false, 4000);
        }
    }"
    x-on:alert.window="open($event.detail.message, $event.detail.type)"
    x-show="show"
    x-transition
    class="fixed top-5 right-5 max-w-xs rounded-md p-4 text-white shadow-lg"
    :class="{
        'bg-green-500': type === 'success',
        'bg-red-600': type === 'error',
        'bg-yellow-500': type === 'warning',
        'bg-blue-500': type === 'info',
    }"
    style="display: none;"
>
    <p x-text="message"></p>
</div>