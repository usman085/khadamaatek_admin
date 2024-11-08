<div class="col-md-12">
    <table class="table table-hover table-bordered">
        <thead>
            <th>@lang("department.websiteName")</th>
            <th>@lang("department.websiteURL")</th>
        </thead>
        @foreach ($websites as $web)
        <tr>
            <th>{{$web->website_name}}</th>
            <td>
                <?php $parsed_url = parse_url($web->website_url); ?>
                <a id="text-to-copy-{{ $web->id }}" href="//{{ (isset($parsed_url['scheme'])) ? $parsed_url['host'] : $parsed_url['path'] }}" target="_blank">{{ $web->website_url }}</a>
                <i class="fa fa-file cusor-pointer" onclick="copyTextToClipboard(`{{ $web->website_url }}`)"></i>
            </td>
        </tr>
        @endforeach
    </table>
</div>
<hr>