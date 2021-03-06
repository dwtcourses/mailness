<?php

namespace App\Jobs;

use App\Import;
use App\Lists;
use App\Services\ImportContacts;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $import;

    protected $custom_fields;

    protected $list;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($custom_fields, Lists $lists, $import_id)
    {
        $this->import = Import::findOrFail($import_id);
        $this->custom_fields = $custom_fields;
        $this->list = $lists;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $importer = new ImportContacts($this->import->id);

        $file = $importer->getFile();
        $header = $importer->getHeaders();

        while (! $file->eof()) {
            $contact = $file->fgetcsv();

            ImportContact::dispatch($contact, $header, $this->list, $this->import, $this->custom_fields);
        }
    }
}
