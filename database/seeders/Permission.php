<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Permission extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("permissions")->insert(['id' => '500','name' => 'Danh mục sản phẩm','key_code' =>NULL, 'parent_id'=>0,]);
        DB::table("permissions")->insert(['id' => '501','name' => 'Xem','key_code' =>'view_category', 'parent_id'=>500,]);
        DB::table("permissions")->insert(['id' => '502','name' => 'Thêm','key_code' =>'update_category', 'parent_id'=>500,]);
        DB::table("permissions")->insert(['id' => '503','name' => 'Sửa','key_code' =>'delete_category', 'parent_id'=>500,]);
        DB::table("permissions")->insert(['id' => '504','name' => 'Xóa','key_code' =>'create_category', 'parent_id'=>500,]);

        DB::table("permissions")->insert(['id' => '530','name' => 'Danh mục bài viết','key_code' =>NULL, 'parent_id'=>0,]);
        DB::table("permissions")->insert(['id' => '531','name' => 'Xem','key_code' =>'view_categorypost', 'parent_id'=>530,]);
        DB::table("permissions")->insert(['id' => '532','name' => 'Thêm','key_code' =>'update_categorypost', 'parent_id'=>530,]);
        DB::table("permissions")->insert(['id' => '533','name' => 'Sửa','key_code' =>'delete_categorypost', 'parent_id'=>530,]);
        DB::table("permissions")->insert(['id' => '534','name' => 'Xóa','key_code' =>'create_categorypost', 'parent_id'=>530,]);

        DB::table("permissions")->insert(['id' => '520','name' => 'Sản phẩm','key_code' =>NULL, 'parent_id'=>0,]);
       DB::table("permissions")->insert(['id' => '521','name' => 'Xem','key_code' =>'view_products', 'parent_id'=>520,]);
       DB::table("permissions")->insert(['id' => '522','name' => 'Thêm','key_code' =>'create_products', 'parent_id'=>520,]);
       DB::table("permissions")->insert(['id' => '523','name' => 'Sửa','key_code' =>'update_products', 'parent_id'=>520,]);
       DB::table("permissions")->insert(['id' => '524','name' => 'Xóa','key_code' =>'delete_products', 'parent_id'=>520,]);


    }
}
