import './bootstrap';
import Alpine from 'alpinejs';

const pathName = location.pathname.replaceAll("/", "");

if (pathName == '') {
    import('./views/home');
} else if (pathName == 'chinh-sua-the-loai') {
    import('./views/chinh_sua_the_loai');
} else if (pathName == 'dang-tai-the-loai') {
    import('./views/dang_tai_the_loai');
} else if (pathName == 'dang-tai-cong-thuc') {
    import('./views/dang_tai_cong_thuc');
} else if (pathName == 'chinh-sua-cong-thuc') {
    import('./views/chinh_sua_cong_thuc');
} else if (pathName == 'cong-thuc') {
    import('./views/cong_thuc');
} else if (pathName == 'dashboard') {
    import('./views/dashboard');
}

window.Alpine = Alpine;

Alpine.start();


