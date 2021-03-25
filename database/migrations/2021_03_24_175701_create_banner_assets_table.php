<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Helpers\BlueprintHelper;

class CreateBannerAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $schema = DB::connection()->getSchemaBuilder();

        $schema->blueprintResolver(function($table, $callback) {
            return new BlueprintHelper($table, $callback);
        });

        $schema->create('banner_assets', function($table) {
            $table->unsignedBigInteger('banner_id');
            $table->unsignedBigInteger('asset_id');
            $table->dateTime('start_time')->nullable();
            $table->dateTime('expired_time')->nullable();

            $table->primary(['banner_id','asset_id']);
            $table->foreign('banner_id')->references('id')->on('banners')->onDelete('cascade');
            $table->foreign('asset_id')->references('id')->on('assets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('banner_assets');
    }
}
