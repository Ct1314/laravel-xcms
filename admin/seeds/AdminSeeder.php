<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->initAdminUser();
        $this->initPermissions();
    }

    public function initPermissions()
    {
        DB::table('admin_permissions')->turncate();
        DB::statement(<<<SQL
INSERT INTO `admin_permissions` VALUES  
('1', '权限模块', '1', 'permissions.index', 'fa-th-list', null, '2017-05-02 09:22:43', '2017-05-02 09:22:43'),
('2', '用户管理', '1', 'users.index', 'fa-users', '1', '2017-05-02 09:23:03', '2017-05-02 09:23:03'),
('3', '角色管理', '2', 'roles.index', 'fa-user', '1', '2017-05-02 09:23:23', '2017-05-02 09:23:23'),
('4', '权限管理', '3', 'permissions.index', 'fa-circle-o', '1', '2017-05-02 09:23:45', '2017-05-02 09:23:57'),
('5', '文章模块', '2', 'articles.index', 'fa-th-list', null, '2017-05-02 09:25:17', '2017-05-04 08:55:17'),
('6', '文章管理', '1', 'articles.index', 'fa-save', '5', '2017-05-02 09:25:37', '2017-05-02 09:25:37'),
('7', '文章分类', '2', 'categories.index', 'fa-files-o', '5', '2017-05-02 09:26:18', '2017-05-02 09:26:18'),
('8', '文章模型', '3', 'modules.index', 'fa-file-o', '5', '2017-05-02 09:26:38', '2017-05-02 09:26:38'),
('9', 'Block', '4', 'blocks.index', 'fa-square', null, '2017-05-02 09:27:02', '2017-05-04 08:55:30'),
('10', 'block管理', '1', 'blocks.index', 'fa-square', '9', '2017-05-02 09:27:24', '2017-05-02 09:27:36'),
('11', 'block分类', '2', 'blockCategories.index', 'fa-minus-square-o', '9', '2017-05-02 09:28:00', '2017-05-02 09:28:00'),
('12', '设置', '6', 'site.index', 'fa-wrench', null, '2017-05-02 09:43:35', '2017-05-04 08:55:47'),
('13', '站点设置', '1', 'site.index', 'fa-circle-o', '12', '2017-05-02 09:43:48', '2017-05-02 09:47:17'),
('14', '页面管理', '3', 'abouts.index', 'fa-file-o', null, '2017-05-04 08:45:48', '2017-05-04 08:55:24'),
('15', '关于页面', '1', 'abouts.index', 'fa-circle-o', '14', '2017-05-04 08:46:09', '2017-05-04 08:46:09'),
('16', '联系页面', '1', 'contacts.index', 'fa-circle-o', '14', '2017-05-04 08:47:11', '2017-05-04 08:47:11'),
('17', '资源空间', '5', 'images.index', 'fa-folder', null, '2017-05-04 08:50:13', '2017-05-04 08:55:52'),
('18', '图片空间', '1', 'images.index', 'fa-circle-o', '17', '2017-05-04 08:50:37', '2017-05-04 08:50:37'),
('19', '视频空间', '1', 'videos.index', 'fa-circle-o', '17', '2017-05-04 08:50:56', '2017-05-04 08:50:56');
SQL
        );
    }

    public function initAdminUser()
    {
        DB::table('admin_users')->insert([
            'name'=>'Administrator',
            'username'=>'admin123',
            'email'=>'admin@email.com',
            'password'=>bcrypt('admin'),
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s'),
        ]);
    }
}
