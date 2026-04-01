<x-filament-panels::page>
    <div class="space-y-4">
        @php $content = $this->getFileContent() @endphp

        @if ($content)
            <x-filament::section>
                <x-slot name="heading">Current security.txt</x-slot>

                <pre class="text-sm font-mono whitespace-pre-wrap break-words text-gray-800 dark:text-gray-200">{{ $content }}</pre>
            </x-filament::section>
        @else
            <x-filament::section>
                <div class="flex items-center gap-3 text-gray-500 dark:text-gray-400">
                    <x-filament::icon icon="heroicon-o-exclamation-triangle" class="h-5 w-5" />
                    <span>
                        No <code class="font-mono text-sm">security.txt</code> file found.
                        Configure <code class="font-mono text-sm">SECURITY_TXT_TEMPLATE_URL</code> in your
                        <code class="font-mono text-sm">.env</code> and click <strong>Update security.txt</strong>.
                    </span>
                </div>
            </x-filament::section>
        @endif

        <x-filament::section>
            <x-slot name="heading">Configuration</x-slot>

            <dl class="grid grid-cols-1 gap-2 text-sm sm:grid-cols-2">
                <div>
                    <dt class="font-medium text-gray-500 dark:text-gray-400">Output path</dt>
                    <dd class="font-mono text-gray-900 dark:text-white">{{ config('security-txt.output_path', '—') }}</dd>
                </div>
                <div>
                    <dt class="font-medium text-gray-500 dark:text-gray-400">Template URL</dt>
                    <dd class="font-mono text-gray-900 dark:text-white">{{ config('security-txt.template_url') ?: '(not set)' }}</dd>
                </div>
                <div>
                    <dt class="font-medium text-gray-500 dark:text-gray-400">Expires in (days)</dt>
                    <dd class="font-mono text-gray-900 dark:text-white">{{ config('security-txt.expires_days', 365) }}</dd>
                </div>
                <div>
                    <dt class="font-medium text-gray-500 dark:text-gray-400">Public URL</dt>
                    <dd class="font-mono text-gray-900 dark:text-white">{{ url('/.well-known/security.txt') }}</dd>
                </div>
            </dl>
        </x-filament::section>
    </div>
</x-filament-panels::page>
