<?php

   use Illuminate\Database\Migrations\Migration;
   use Illuminate\Database\Schema\Blueprint;
   use Illuminate\Support\Facades\Schema;

   return new class extends Migration
   {
       public function up()
       {
           Schema::table('listings', function (Blueprint $table) {
               // Add new columns (only if they don’t exist)
               if (!Schema::hasColumn('listings', 'description')) {
                   $table->string('description')->nullable()->after('title');
               }
               if (!Schema::hasColumn('listings', 'hotel_category')) {
                   $table->string('hotel_category')->after('description');
               }
               if (!Schema::hasColumn('listings', 'location_country')) {
                   $table->string('location_country')->after('hotel_category');
               }
               if (!Schema::hasColumn('listings', 'location_city')) {
                   $table->string('location_city')->after('location_country');
               }
               if (!Schema::hasColumn('listings', 'price_per_night')) {
                   $table->integer('price_per_night')->after('location_city');
               }
               if (!Schema::hasColumn('listings', 'number_of_rooms')) {
                   $table->integer('number_of_rooms')->after('price_per_night');
               }
               if (!Schema::hasColumn('listings', 'hotel_email')) {
                   $table->string('hotel_email')->after('number_of_rooms');
               }

               // Ensure image_url is text/json (already exists, so adjust type if needed)
               if (Schema::hasColumn('listings', 'image_url')) {
                   $table->text('image_url')->nullable()->change();
               }

               // Remove unwanted columns if they exist
               if (Schema::hasColumn('listings', 'room_type')) {
                   $table->dropColumn('room_type');
               }
               if (Schema::hasColumn('listings', 'room_amenities')) {
                   $table->dropColumn('room_amenities');
               }
               if (Schema::hasColumn('listings', 'general_amenities')) {
                   $table->dropColumn('general_amenities');
               }
               if (Schema::hasColumn('listings', 'available_to')) {
                   $table->dropColumn('available_to');
               }
           });
       }

       public function down()
       {
           Schema::table('listings', function (Blueprint $table) {
               $table->dropColumn(['description', 'hotel_category', 'location_country', 'location_city', 'price_per_night', 'number_of_rooms', 'hotel_email']);
               // Revert image_url type if needed
               if (Schema::hasColumn('listings', 'image_url')) {
                   $table->string('image_url')->nullable()->change();
               }
               // Optionally re-add removed columns if required
               // $table->string('room_type')->after('location_city');
               // $table->json('room_amenities')->after('room_type');
               // $table->json('general_amenities')->after('room_amenities');
               // $table->dateTime('available_to')->after('image_url');
           });
       }
   };