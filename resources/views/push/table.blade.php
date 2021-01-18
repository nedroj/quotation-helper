@foreach($issuelists as $issuelist)
    <h4>{{ $issuelist->name }} @foreach($issuelist->tags as $tag)<span class="badge badge-secondary">{{ $tag->name }}</span> @endforeach</h4>
    <label for="select_all_{{$issuelist->id}}"><input type="checkbox" id="select_all_{{$issuelist->id}}" class="select-all" checked> Selecteer alles</label>

    <table class="table table-striped table-sm">
        <thead>
        <tr>
            <th></th>
            <th>{{ __('Name') }}</th>
            <th>{{ __('Description') }}</th>
            <th>{{ __('Original estimate (minutes)') }}</th>
        </tr>
        <tbody>
            @forelse($issuelist->issues as $issue)
                <tr>
                    <td>
                        <input type="hidden"   name="enabled_issuelist[{{ $issuelist->id }}][issues][{{ $issue->id }}][enabled]" value="0">
                        <input type="checkbox" name="enabled_issuelist[{{ $issuelist->id }}][issues][{{ $issue->id }}][enabled]" value="1" checked>
                    </td>
                    <td>{{ $issue->name }}</td>
                    <td>{!! $issue->description !!}</td>
                    <td><input type="number" name="enabled_issuelist[{{ $issuelist->id }}][issues][{{ $issue->id }}][original_estimate]" value="{{ $issue->original_estimate }}"></td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">{{ __('No issues found') }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endforeach
