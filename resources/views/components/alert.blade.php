<div
    x-data="{
        show: false,
        message: '',
        type: 'success',
        open(message, type = 'success') {
            this.message = message;
            this.type = type;
            this.show = true;
            setTimeout(() => this.show = false, 5000);
        },
        close() {
            this.show = false;
        }
    }"
    x-on:alert.window="open($event.detail.message, $event.detail.type)"
    x-show="show"
    x-transition:enter="transition ease-out duration-300 transform"
    x-transition:enter-start="opacity-0 translate-y-2"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-200 transform"
    x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 translate-y-2"
    class="fixed top-6 right-6 z-50 max-w-sm"
    style="display: none;"
>
    <div class="bg-white rounded-2xl shadow-lg border overflow-hidden"
         :class="{
             'border-green-200': type === 'success',
             'border-red-200': type === 'error',
             'border-yellow-200': type === 'warning',
             'border-blue-200': type === 'info',
         }">
        
        <div class="p-4">
            <div class="flex items-start space-x-3">
                
                <div class="flex-shrink-0 mt-0.5">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center"
                         :class="{
                             'bg-green-100': type === 'success',
                             'bg-red-100': type === 'error',
                             'bg-yellow-100': type === 'warning',
                             'bg-blue-100': type === 'info',
                         }">
                        <i class="text-sm"
                           :class="{
                               'ri-check-line text-green-600': type === 'success',
                               'ri-close-line text-red-600': type === 'error',
                               'ri-alert-line text-yellow-600': type === 'warning',
                               'ri-information-line text-blue-600': type === 'info',
                           }"></i>
                    </div>
                </div>
                
                <div class="flex-grow min-w-0">
                    <p class="text-sm font-medium text-gray-900 leading-relaxed" x-text="message"></p>
                </div>
                
                <button @click="close()" 
                        class="flex-shrink-0 text-gray-400 hover:text-gray-600 transition-colors duration-200 p-1">
                    <i class="ri-close-line text-sm"></i>
                </button>
            </div>
        </div>

        <div class="h-1 w-full overflow-hidden"
             :class="{
                 'bg-green-100': type === 'success',
                 'bg-red-100': type === 'error',
                 'bg-yellow-100': type === 'warning',
                 'bg-blue-100': type === 'info',
             }">
            <div class="h-full animate-progress"
                 :class="{
                     'bg-green-500': type === 'success',
                     'bg-red-500': type === 'error',
                     'bg-yellow-500': type === 'warning',
                     'bg-blue-500': type === 'info',
                 }"></div>
        </div>
    </div>
</div>
