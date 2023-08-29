<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 ">

    <div class="py-7">
    <div class="block rounded-lg bg-white p-6 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] dark:bg-neutral-700">
        <h1
            class="mb-2 text-xl font-medium leading-tight text-neutral-800 dark:text-neutral-50">
            {{ $movie->title }} ({{ \Carbon\Carbon::parse($movie->release_date)->format('Y') }})
        </h1>
        <p class="mb-4 text-base text-neutral-600 dark:text-neutral-200">
            {{ $movie->tagline }}
        </p>
        @if($movie->poster)
            <img src="{{ $movie->poster }}"/>
        @endif
        <p class="mb-4 text-base text-neutral-600 dark:text-neutral-200">
            {{ $movie->overview }}
        </p>
        <p class="mb-4 text-base text-neutral-600 dark:text-neutral-200">
            <strong>Date de sortie :</strong> {{ \Carbon\Carbon::parse($movie->release_date)->translatedFormat('d F Y') }}
        </p>
        <p class="mb-4 text-base text-neutral-600 dark:text-neutral-200">
            @foreach($movie->moviesGenres as $genre)
                <span class="bg-blue-100 text-blue-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">{{ $genre->name }}</span>
            @endforeach
        </p>
    </div>
</div>
</div>
