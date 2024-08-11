<?php

namespace App\Adapters;

use App\Models\PreviewData;
use App\Models\Data;

class PreviewAdapter implements PreviewAdapterInterface
{
    public function getPreviewData($uniqueId)
    {
        $previewData = [];
        $qPreview = PreviewData::where('unique_id', $uniqueId)->get();
        foreach ($qPreview as $preview) {
            $q1 = Data::where('rekon', $preview->rekon)
                ->where('id_valins', $preview->id_valins)->first();
            if ($q1) {
                PreviewData::where('id', $preview->id)->update([
                    'isValid' => 0
                ]);
            }
        }
        $previewData['qPreviewNotValid'] =
            PreviewData::where('unique_id', $uniqueId)->where('isValid', 0)
            ->get();
        $previewData['qPreviewValid'] = PreviewData::where(
            'unique_id',
            $uniqueId
        )->where('isValid', 1)->get();
        return $previewData;
    }
}
