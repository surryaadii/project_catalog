<?php 
namespace App\Helpers;

use Illuminate\Database\Schema\Blueprint;

class BlueprintHelper extends Blueprint
{
    public function addLogColumns() {
        $this->timestamp('created_at')->nullable();
        $this->bigInteger('created_by')->nullable();
        $this->timestamp('updated_at')->nullable();
        $this->bigInteger('updated_by')->nullable();
        $this->timestamp('deleted_at')->nullable();
        $this->bigInteger('deleted_by')->nullable();
    }
}

