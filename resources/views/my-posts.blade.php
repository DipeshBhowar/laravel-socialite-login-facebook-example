<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="container mt-4">
        <div>
            @foreach ($data as $key => $value)
                <div style="margin: 10px;background-color: #ffffff;padding: 10px;display: flex;flex-direction: column;"
                    hidden>
                    {{ $value->id }}
                    <span>Title : {{ $value->post_title }}</span>
                    <span>Content : {{ $value->post_content }}</span>
                    <span>Media : {{ $value->post_media }}</span>

                    @if ($value->media_type != 'mp4')
                        <img src="{{ asset('images/' . $value->post_media) }}" alt="" width="350px" height="auto">
                    @else
                        <video src="{{ asset('images/' . $value->post_media) }}" width="350px" height="auto"></video>
                    @endif

                    {{-- @if ($value->media_type == 'pdf')
                        <iframe
                            src="https://drive.google.com/viewerng/viewer?embedded=true&url={{asset('images/' . $value->post_media)}}"
                            frameBorder="0" scrolling="auto" height="100%" width="100%"></iframe>
                    @elseif ($value->media_type == 'mp4')
                        <video src="{{ asset('images/' . $value->post_media) }}" width="350px" height="auto"></video>
                    @elseif ($value->media_type != 'mp4' && $value->media_type != 'pdf')
                        <img src="{{ asset('images/' . $value->post_media) }}" alt="" width="350px" height="auto">
                    @endif --}}

                    <form action="{{ url('/') }}/edit-post/{{ $value->id }}" method="post">
                        @csrf
                        <input style="background-color: #ccc;padding: 12px 16px;cursor: pointer;" type="submit"
                            value="Submit">
                    </form>
                </div>
            @endforeach
        </div>

        <h1 class="text-center display-3">My Posts</h1>
        <div class="">
            <div class="row">
                @foreach ($data as $key => $value)
                    <div class="col-lg-6 mb-4">
                        <div class="card">
                            @if ($value->media_type != 'mp4')
                                <img class="card-img-top" src="{{ asset('images/' . $value->post_media) }}" alt=""
                                    width="350px" height="auto">
                            @else
                                <video class="card-img-top" src="{{ asset('images/' . $value->post_media) }}"
                                    width="350px" height="auto"></video>
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $value->post_title }}</h5>
                                <p class="card-text">{{ $value->post_content }}</p>
                            </div>

                            <div class="card-footer">
                                <form action="{{ url('delete/' . $value->id) }}" method="get">
                                    <input type="submit" value="Delete">
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
