<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class CountryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "identifier" => $this->id,
            "name" => $this->name,
            "image" => $this->image,
            "created" => $this->created_at->diffForHumans(),
            "updated" => $this->updated_at->diffForHumans(),
            "joins" => [

                /* SQL RAW JOINS 
                //Citizen 
                "country_citizens" => 
                    DB::select("SELECT `ci`.`id` AS `citizen_identifier`, `ci`.`name` AS `citizen_name`, `ci`.`email` AS `citizen_email`, CASE `ci`.`status` 
                        WHEN 1 THEN 'Cititzen status is Active'
                        ELSE 'Citizen status is Inactive'
                        END AS `citizen_status` 
                            FROM `restfulapi_country`.`countries` AS `co` JOIN `restfulapi_country`.`citizens` AS `ci` ON `co`.`id`=`ci`.`country_id`"),

                //Number
                "country_numbers" => 
                    DB::select("SELECT `n`.`number`, CASE `n`.`citizen_id`
                        WHEN `n`.`citizen_id` THEN `ci`.`name`
                        END AS `citizen_identifier`, CASE `n`.`status` 
                        WHEN 1 THEN 'Number status is Active'
                        ELSE 'Number status is Inactive'
                        END `number_status` 
                            FROM `restfulapi_country`.`countries` AS `co` JOIN `restfulapi_country`.`citizens` AS `ci` ON `co`.`id`=`ci`.`country_id` JOIN `restfulapi_country`.`numbers` AS `n` ON `ci`.`id`=`n`.`citizen_id`"),
                
                //CountryBlog
                "country_blogs" => 
                    DB::select("SELECT CASE `cb`.`citizen_id` 
                        WHEN `cb`.`citizen_id` THEN `ci`.`name`
                        END AS `citizen_identifier`, `cb`.`name` AS `country_blog_name`, `cb`.`population` AS `country_blog_population`, `cb`.`area_code` AS `country_blog_area_code`, `cb`.`image` AS `country_blog_image` FROM `restfulapi_country`.`countries` AS `co` JOIN `restfulapi_country`.`citizens` AS `ci` ON `co`.`id`=`ci`.`country_id` JOIN `restfulapi_country`.`country_blogs` AS `cb` ON `ci`.`id`=`cb`.`citizen_id`"),

                //Mountain
                "mountains" => 
                    DB::select("SELECT CASE `m`.`country_blog_id`
                        WHEN `m`.`country_blog_id` THEN `cb`.`name`
                        END AS `country_blog_identifier`, `m`.`name` AS `mountain_name`, `m`.`elevation` AS `mountain_elevation`, `m`.`promience` AS `mountain_promience`, `m`.`coordination` AS `mountain_coordination`, `m`.`isolation` AS `mountain_isolation` FROM `restfulapi_country`.`countries` AS `co` JOIN `restfulapi_country`.`citizens` AS `ci` ON `co`.`id`=`ci`.`country_id` JOIN `restfulapi_country`.`country_blogs` AS `cb` ON `ci`.`id`=`cb`.`citizen_id` JOIN `restfulapi_country`.`mountains` AS `m` ON `cb`.`id`=`m`.`country_blog_id`"),

                //River
                "rivers" => 
                    DB::select("SELECT CASE `r`.`country_blog_id` 
                        WHEN `r`.`country_blog_id` THEN `cb`.`name`
                        END AS `country_blog_identifier`, `r`.`name` AS `river_name`, `r`.`length` AS `river_length`, `r`.`size` AS `river_size`, `r`.`coordinates` AS `river_coordinates` FROM `restfulapi_country`.`countries` AS `co` JOIN `restfulapi_country`.`citizens` AS `ci` ON `co`.`id`=`ci`.`country_id` JOIN `restfulapi_country`.`country_blogs` AS `cb` ON `ci`.`id`=`cb`.`citizen_id` JOIN `restfulapi_country`.`rivers` AS `r` ON `cb`.`id`=`r`.`country_blog_id`"),
                */


                /*DB Query Builder 
                //Citizenz
                "citizens" => 
                    DB::table("countries AS co")->join("citizens AS ci", function($join) {
                        $join->on("co.id", "=", "ci.country_id");
                    })->select(DB::raw("CASE `ci`.`country_id`
                        WHEN `ci`.`country_id` THEN `co`.`name`
                        END AS `country_identifier`, `ci`.`name` AS `citizen_name`, `ci`.`email` AS `citizen_email`, CASE `ci`.`status` 
                            WHEN 1 THEN 'Citizen status is Active'
                            ELSE 'Citizen status is Inactive'
                            END AS `citizen_status`, `ci`.`image` AS `citizen_image`"))
                        ->get(),

                //Numbers
                "numbers" => 
                    DB::table("countries AS co")->join("citizens AS ci", function($join) {
                        $join->on("co.id", "=", "ci.country_id");
                    })->join("numbers AS n", function($join) {
                        $join->on("ci.id", "=", "n.citizen_id");
                    })->select(DB::raw("CASE `n`.`citizen_id` 
                        WHEN `n`.`citizen_id` THEN `ci`.`name`
                        END AS `citizen_identifier`, `n`.`number` AS `number`, CASE `n`.`status` 
                            WHEN 1 THEN 'Number status is Active'
                            ELSE 'Number status is Inactive'
                            END AS `number_status`"))
                        ->get(),

                //CountryBlogs
                "country_blogs" => 
                    DB::table("countries AS co")->join("citizens AS ci", function($join) {
                        $join->on("co.id", "=", "ci.country_id");
                    })->join("country_blogs AS cb", function($join) {
                        $join->on("ci.id", "=", "cb.citizen_id");
                    })->select(DB::raw("CASE `cb`.`citizen_id` 
                        WHEN `cb`.`citizen_id` THEN `ci`.`name`
                        END AS `citizen_identifier`, `cb`.`name` AS `country_blog_name`, `cb`.`population` AS `country_blog_population`, `cb`.`area_code` AS `country_blog_area_code`, `cb`.`image` AS `country_blog_image`"))
                        ->get(),

                //Mountains 
                "mountains" => 
                    DB::table("countries AS co")->join("citizens AS ci", function($join) {
                        $join->on("co.id", "=", "ci.country_id");
                    })->join("country_blogs AS cb", function($join) {
                        $join->on("ci.id", "=", "cb.citizen_id");
                    })->join("mountains AS m", function($join) {
                        $join->on("cb.id", "=", "m.country_blog_id");
                    })->select(DB::raw("CASE `m`.`country_blog_id` 
                        WHEN `m`.`country_blog_id` THEN `cb`.`name`
                        END AS `country_blog_identifier`, `m`.`name` AS `mountain_name`, `m`.`elevation` AS `mountain_elevation`, `m`.`promience` AS `mountain_promience`, `m`.`coordination` AS `countain_coordination`, `m`.`isolation` AS `mountain_isolation`"))
                        ->get(),

                //Rivers
                "rivers" => 
                    DB::table("countries AS co")->join("citizens AS ci", function($join) {
                        $join->on("co.id", "=", "ci.country_id");
                    })->join("country_blogs AS cb", function($join) {
                        $join->on("ci.id" , "=", "cb.citizen_id");
                    })->join("rivers AS r", function($join) {
                        $join->on("cb.id", "=", "r.country_blog_id");
                    })->select(DB::raw("CASE `r`.`country_blog_id`
                        WHEN `r`.`country_blog_id` THEN `cb`.`name`
                        END AS `country_blog_identifier`, `r`.`name` AS `river_name`, `r`.`length` AS `river_length`, `r`.`size` AS `river_size`, `r`.`coordinates` AS `river_coordinates`"))
                        ->get(),
                */

                //Citizens
                "citizens" => [
                    "country_identifier" => $this->name,
                    "citizen_name" => $this->citizens->pluck("name")->first(),
                    "citizen_email" => $this->citizens->pluck("email")->first(),
                    "citizen_status" => $this->citizens->pluck("status")->first() === 1 ? "Active" : "Inactive",
                    "citizen_image" => $this->citizens->pluck("image")->first(),
                    "citizen_created" => $this->citizens->pluck("created_at")->first(),
                    "citizen_updated" => $this->citizens->pluck("updated_at")->first()
                ],

                //Numbers
                "numbers" => [
                    "citizen_identifier" => $this->citizens->pluck("name")->first(),
                    "number" => $this->numbers->pluck("number")->first(),
                    "number_status" => $this->numbers->pluck("status")->first() === 1 ? "Active" : "Inactive",
                    "number_created" => $this->numbers->pluck("created_at")->first()->diffForHumans(),
                    "number_updated" => $this->numbers->pluck("updated_at")->first()->diffForHumans()
                ],

                //CountryBlogs
                "country_blogs" => [
                    "citizen_identifier" => $this->citizens->pluck("name")->first(),
                    "country_blog_name" => $this->country_blogs->pluck("name")->first(),
                    "country_blog_population" => $this->country_blogs->pluck("population")->first(),
                    "country_blog_area_code" => $this->country_blogs->pluck("area_code")->first(),
                    "country_blog_description" => $this->country_blogs->pluck("description")->first(),
                    "country_blog_image" => $this->country_blogs->pluck("image")->first(),
                    "country_blog_created" => $this->country_blogs->pluck("created_at")->first()->diffForHumans(),
                    "country_blog_updated" => $this->country_blogs->pluck("updated_at")->first()->diffForHumans()
                ],

                //Mountains
                "mountains" => [
                    "country_blog_identifier" => $this->country_blogs->pluck("name")->first(),
                    "mountain_name" => $this->mountains->pluck("name")->first(),
                    "mountain_elevation" => $this->mountains->pluck("elevation")->first(),
                    "mountain_promience" => $this->mountains->pluck("promience")->first(),
                    "mountain_coordination" => $this->mountains->pluck("coordination")->first(),
                    "mountain_isolation" => $this->mountains->pluck("isolation")->first(),
                    "mountain_description" => $this->mountains->pluck("description")->first(),
                    "mountain_first_image" => $this->mountains->pluck("image1")->first(),
                    "mountain_second_image" => $this->mountains->pluck("image2")->first(),
                    "mountain_third_image" => $this->mountains->pluck("image3")->first(),
                    "mountain_created" => $this->mountains->pluck("created_at")->first()->diffForHumans(),
                    "mountain_updated_at" => $this->mountains->pluck("updated_at")->first()->diffForHumans()
                ], 

                //Rivers 
                "rivers" => [
                    "country_blog_identifier" => $this->country_blogs->pluck("name")->first(),
                    "river_name" => $this->rivers->pluck("name")->first(),
                    "river_length" => $this->rivers->pluck("length")->first(),
                    "river_size" => $this->rivers->pluck("size")->first(),
                    "river_coordinates" => $this->rivers->pluck("coordinates")->first(),
                    "river_description" => $this->rivers->pluck("description")->first(),
                    "river_first_image" => $this->rivers->pluck("image1")->first(),
                    "river_second_image" => $this->rivers->pluck("image2")->first(),
                    "river_third_image" => $this->rivers->pluck("image3")->first(),
                    "river_created" => $this->rivers->pluck("created_at")->first()->diffForHumans(),
                    "river_updated" => $this->rivers->pluck("updated_at")->first()->diffForHumans()
                ],
            ]
        ];
    }
}
