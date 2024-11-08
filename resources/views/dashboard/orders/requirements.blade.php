<div class="modal-header">
    <h5 class="modal-title">{{ $data['template_name'] }}</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-lg-12">
            <?php $index = 1; ?>
            @foreach($data['array'] as $item)
                @if ($index === 1)
                    <div>
                @else
                    <div class="mt-5">
                @endif
                    <h3 style="font-weight: 600;">{{ $item['customer_document']['label'] }}</h3>
                    <table class="table table-hover requirementsTable">
                        <tbody>
                            @foreach ($item['customer_document']['dataModel'] as $key => $value)
                            <tr>
                                <th>{{ $key }}</th>
                                @if(strpos($value, 'attachment') !== false)
                                <td>
                                    @php
                                        $image = asset("/customer_documents/$value");
                                    @endphp
                                    <?php $image_type = exif_imagetype(public_path() . "/customer_documents/{$value}"); ?>
                                    <a href="{{$image}}" target='_blank'>
                                        @if ($image_type > 0 && $image_type
                                        < 19) <img src="{{$image}}" title="Image" class='img-fluid'
                                            alt="{{ $value }}" style="max-height: 220px;" />
                                        @else
                                        <img src='/images/file.png' title="Document File" class='img-fluid'
                                            alt="{{ $value }}" style="max-height: 220px;" />
                                        @endif
                                    </a>
                                </td>
                                @else
                                @if(strpos($value, 'dateTimeStamp-') !== false)
                                <td>{{ date('Y-m-d', strtotime(str_replace("dateTimeStamp-","", $value))) }}</td>
                                @else
                                <td>{{ ($value) ? $value : '-'}}</td>
                                @endif
                                @endif
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                    <hr>
                </div>
                <?php $index++; ?>
            @endforeach
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('common.close')</button>
</div>
