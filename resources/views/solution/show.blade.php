@if($empty)
    <p class="fg-white z-2 p-3 h1 leader display1" style="min-width: 450px">Nenhum resultado encontrado</p>
@else
    <div data-role="accordion" data-material="true" data-one-frame="false" data-show-active="true" class="mt-5"
         data-active-heading-class="bg-lightCyan fg-white"
         data-active-content-class="bg-white fg-black">
        @foreach($solutions as $solution)
            <div class="frame" style="min-width: 450px">
                <div class="heading">{{$solution->id}} - {{$solution->name}}</div>
                <div class="content">
                    <div class="p-2">{{$solution->sDescription}}</div>
                    <div>
                        <div class="info-button rounded mt-4" id="solutionattr{{$solution->sId}}">
                            <a href="#" class="button" onclick="solutionUpdate('{{$solution->sId}}', '{{csrf_token()}}', '{{$solution->useful}}')">
                                <span class="mif-thumbs-up"></span> Útil</a>
                            <a href="#" class="info" id="useful{{$solution->sId}}">{{$solution->useful}}</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
<span class="mif-cancel mif-2x fg-white c-pointer fg-cyan-hover" onclick="$('#top-charms').data('charms').toggle();"
      style="position: absolute; left: 5px; top: 5px;">
</span>

<script>
    function solutionUpdate(id, token, useful) {
        useful = parseInt(useful) + 1;
        url = '/bioclin/solutions/' + id;
        $.ajax({
            url: url,
            type: 'PUT',
            dataType: 'json',
            data: {
                '_token': token,
                'useful': useful
            },
            success: function (data) {
                console.info(data)
                $('#useful' + id).html(useful);
            }
        });
    }
</script>