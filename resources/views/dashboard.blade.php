<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>

    </x-slot>

    <div class="container mt-4">

        <div class="row">

            <div class="col-lg-6 mb-4">
                <form action="{{ url('/') }}/create-post" method="post" enctype="multipart/form-data">
                    @csrf
                    <input class="form-control mt-4" type="text" name="title" placeholder="Title" required>
                    <textarea class="form-control mt-4" name="content" id="" cols="30" rows="4" placeholder="Blog Content"></textarea>
                    <input class="form-control mt-4" type="file" id="img" name="media"
                        accept="image/*,video/*,application/pdf">
                    <input style="color: #121212" class="btn btn-primary mt-2" type="submit" value="Post">
                </form>
            </div>

            @foreach ($data as $key => $value)
                <div class="col-lg-6 mb-4">
                    <div class="card" style="">
                        @if ($value->media_type != 'mp4')
                            <img class="card-img-top" src="{{ asset('images/' . $value->post_media) }}" alt="Image"
                                width="350px" height="auto">
                        @else
                            <video class="card-img-top" src="{{ asset('images/' . $value->post_media) }}"
                                width="350px" height="auto" type="video/{{ $value->media_type }}" controls></video>
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $value->post_title }}</h5>
                            <p class="card-text">{{ $value->post_content }}</p>
                            {{-- <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p> --}}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</x-app-layout>
