<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 ">

    <div class="py-7">
        <ul class="grid grid-cols-2 gap-4">

            @foreach ($movies as $movie)
                <li>
                    <a wire:navigate href="{{ route('movie',['id'=>$movie->id]) }}"
                       class="flex flex-col rounded-lg bg-white shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] dark:bg-neutral-700 md:max-w-xl md:flex-row">

                        @if($movie->poster)
                            <img class="rounded-lg" src="{{ $movie->poster }}" width="100"/>
                        @endif

                        <div class="flex flex-col justify-start p-6">

                            <h5 class="mb-2 text-xl font-medium text-neutral-800 dark:text-neutral-50">
                                {{ $movie->title }}
                            </h5>

                            @if($movie->release_date)
                                <p class="mb-2 text-l font-medium text-neutral-800 dark:text-neutral-50">({{ \Carbon\Carbon::parse($movie->release_date)->format('Y') }})</p>
                            @endif

                            @if($movie->tagline)
                                <p class="mb-4 text-base text-neutral-600 dark:text-neutral-200">
                                    {{ $movie->tagline }}
                                </p>
                            @endif

                            @if($movie->moviesGenres->count() > 0)
                                <p class="mb-4 text-base text-neutral-600 dark:text-neutral-200">
                                    @foreach($movie->moviesGenres as $genre)
                                        <span class="bg-blue-100 text-blue-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">{{ $genre->name }}</span>
                                    @endforeach
                                </p>
                            @endif

                        </div>
                    </a>
                </li>
            @endforeach

        </ul>

    </div>

    <div class="py-7">
        {{ $movies->links() }}
    </div>

</div>
