@foreach($issuelists as $issuelist)
    <div class="form-check">
        <input class="form-check-input issuelist_checkbox"
               type="checkbox"
               name="issuelists[]"
               id="issuelist_{{ $issuelist->id }}"
               value="{{ $issuelist->id }}">
        <label class="form-check-label"
               for="issuelist_{{ $issuelist->id }}">
            {{ $issuelist->name }}
            @foreach($issuelist->tags as $tag) <span class="badge badge-secondary">{{ $tag->name }}</span>@endforeach
        </label>
    </div>
@endforeach
