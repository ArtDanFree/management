<?php

namespace App\Http\Controllers;

use App\Http\Requests\LeadImageStoreRequest;
use App\Models\Lead;
use App\Models\LeadImage;
use Intervention\Image\Facades\Image;

class LeadImageController extends Controller
{
    public function store(LeadImageStoreRequest $request)
    {
        if (\Gate::allows('add-own-lead-image', $request->lead_id)) {

            if ($this->filesMoreTen($request)) {
                return back()->withErrors(__('error.you_can_not_upload_more_than_15_files'));
            }

            foreach ($request->file('documents') as $key => $file) {
                $str = str_random(100);

                if ($file->getMimeType() == 'application/pdf') {
                    $pathBD = $file->store('documents/', 'public');
                } else {
                    $img = Image::make($file)->encode('jpg', 75);
                    $pathBD = 'documents/' . $str . '.jpg';
                    $pathDisc = 'public/documents/' . $str . '.jpg';
                    \Storage::put($pathDisc, $img);
                }
                LeadImage::create([
                    'name' => $file->getClientOriginalName(),
                    'lead_id' => $request->lead_id,
                    'img' => $pathBD,

                ]);
            }
            return \Redirect::back()->with('message', [__('message.doc_added')]);
        } else {
            return back()->with('message', [__('message.no_rights')]);
        }
    }

    public function filesMoreTen($request)
    {
        $countFiles = count($request->file('documents')) + Lead::find($request->lead_id)->leadImage->count();
        if ($countFiles > 15) {
            return true;
        } else {
            return false;
        }
    }

    public function destroy($id)
    {
        $img = LeadImage::find($id);

        if (\Gate::allows('destroy-own-lead-image', $img)) {

            unlink(public_path('storage/' . $img->img));
            $img->delete();
            return \Redirect::back();

        } else {
            return back()->with('message', [__('message.no_rights')]);
        }
    }
}
