<?php

namespace App\Services;

use App\Models\DailyEntry;

class DailyEntryService
{

    public function getAllDailyEntries($per_page = -1)
    {
        if($per_page == -1){
            return DailyEntry::orderBy('created_at', 'desc')->get();    
        }
        return DailyEntry::orderBy('created_at', 'desc')->paginate($per_page);
    }

    public function getDailyEntryById($id)
    {
        return DailyEntry::find($id);
    }

    public function create($data)
    {
        return DailyEntry::create($data);
    }

    public function update($daily_entries, $data)
    {
        return $daily_entries->update($data);
    }

    public function delete($daily_entries)
    {
        return $daily_entries->delete($daily_entries);
    }

    public function getDailyEntriesByEnqId($enquiry_id)
    {
        return DailyEntry::where('enquiry_id', $enquiry_id)->orderBy('journey_date', 'asc')->get(); 
    }

    public function checkEntryExists($enquiry_id, $journey_date)
    {
        return DailyEntry::where('enquiry_id', $enquiry_id)->where('journey_date', $journey_date)->count(); 
    }

    public function getAllEntriesByFilter($request)
    {
        $query = DailyEntry::where('enquiry_id', $request->enquiry_id)->orderBy('journey_date', 'asc');
        if($request->start_date && $request->end_date){
            $startDate = date("Y-m-d", strtotime(str_replace('/', '-', $request->start_date)));
            $endDate = date("Y-m-d", strtotime(str_replace('/', '-', $request->end_date)));
            $query = $query->whereBetween('journey_date', [$startDate, $endDate]);
        }
        return $query->select('*')->get();
    }
}
