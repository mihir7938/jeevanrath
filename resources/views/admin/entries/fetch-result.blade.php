<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Entries</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="fetch_entry_data" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th></th>
                        <th>Date</th>
                        <th>Starting KM</th>
                        <th>Closing KM</th>
                        <th>KM Diff</th>
                        <th>Extra KM</th>
                        <th>In Time</th>
                        <th>Out Time</th>
                        <th>OT Hrs.</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th>Total:</th>
                        <th>{{$difference}}</th>
                        <th>{{$extra_km}}</th>
                        <th></th>
                        <th></th>
                        <th>{{$extra_ot}}</th>
                        <th></th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach($daily_entries as $entry)
                        <tr>
                            <td class="text-center"></td>
                            <td>{{Carbon\Carbon::parse($entry->journey_date)->format('j-M-Y')}}</td>
                            <td>{{$entry->starting_kilometer}}</td>
                            <td>{{$entry->closing_kilometer}}</td>
                            <td>{{$entry->difference}}</td>
                            <td>{{$entry->extra_km}}</td>
                            <td>{{$entry->in_time}}</td>
                            <td>{{$entry->out_time}}</td>
                            <td>{{$entry->ot_hrs}}</td>
                            <td>{{$entry->remarks}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>