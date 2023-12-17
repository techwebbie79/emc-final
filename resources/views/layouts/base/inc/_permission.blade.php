@php
global $menu;
$menu = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20];
if (globalUserInfo()->role_id == 1) {
    $menu = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20];
} elseif (globalUserInfo()->role_id == 2) {
    $menu = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16];
} elseif (globalUserInfo()->role_id == 6) {
    $menu = [1, 2, 3, 5, 6, 11, 12, 13, 17, 18, 19];
} elseif (globalUserInfo()->role_id == 24) {
    $menu = [1, 2, 3, 5, 6, 11, 12, 13, 17, 18, 19];
} elseif (globalUserInfo()->role_id == 25) {
    $menu = [1, 2, 3, 5, 6, 11, 12, 13, 17, 18, 19];
} elseif (globalUserInfo()->role_id == 27) {
    $menu = [1, 2, 3, 6, 7, 8, 9, 10, 11, 12, 13, 17, 18, 19];
} elseif (globalUserInfo()->role_id == 28) {
    $menu = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 17, 18, 19];
} elseif (globalUserInfo()->role_id == 32) {
    $menu = [1, 2, 3, 5, 6, 11, 12, 13, 17, 18, 19];
} elseif (globalUserInfo()->role_id == 33) {
    $menu = [1, 2, 3, 5, 6, 11, 12, 13, 17, 18, 19];
} elseif (globalUserInfo()->role_id == 34) {
    $menu = [1, 2, 3, 5, 6, 11, 12, 13, 17, 18, 19];
} elseif (globalUserInfo()->role_id == 35) {
    $menu = [1, 3, 4, 5, 6, 7, 8, 9, 12];
} elseif (globalUserInfo()->role_id == 36) {
    $menu = [1, 3, 5, 6, 7, 8, 9, 12];
}
@endphp
