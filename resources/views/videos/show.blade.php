<x-casteaching-layout>
    <div class="flex flex-col space-x-4 space-y-4 lg:space-x-6 lg:space-y-4 xl:space-x-15 xl:space-y-5
2xl:space-x-20 2xl:space-y-10 items-center">
            <iframe
                class="md:p-3 lg:p-5 xl:px-10 xl:py-5 2xl:px-20 2xl:py-10 h-4/5 w-full"
                style="height: 75vh"
                src="https://www.youtube.com/embed/AawLM81gIHo"
                title="YouTube video player" frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen>
            </iframe>

        <div class="pr-4">
            <div class="p-3 bg-white rounded-lg shadow-lg max-w-8xl w-full border-t-2 border-red-400 rounded-t-none">
                <h2 class="text-gray-900 uppercase font-bold text-2xl tracking-tight border-b border-gray-300">
                    {{ $video->title }}
                </h2>
                <!-- This example requires Tailwind CSS v2.0+ -->
                <div class="bg-gray-50">
                    <div class="mt-5 pb-5 bg-white sm:pb-5">
                        <div class="relative">
                            <div class="relative max-w-7xl px-4 sm:px-6 lg:px-8">
                                    <dl class="rounded-lg bg-gray-200 shadow-lg">
                                        <div class="flex flex-col border-b border-gray-200 p-2 text-center sm:border-0 sm:border-r">
                                            <dt class="order-2 mt-2 text-lg leading-6 text-gray-500">
                                                Data de publicació
                                            </dt>
                                            <dd class="order-1 text-2xl font-extrabold text-red-400">
                                                {{ $video->formated_published_at }}
                                            </dd>
                                        </div>
                                    </dl>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="prose-sm md:prose lg:prose-xl 2xl:prose-2xl mt-4">
                {!! Str::markdown($video->description) !!}
            </div>
        </div>
    </div>
</x-casteaching-layout>
