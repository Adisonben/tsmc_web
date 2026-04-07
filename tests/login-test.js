import http from 'k6/http';
import { check, sleep } from 'k6';

export const options = {
  vus: 20,
  duration: '30s',
};

export default function () {
  // 1. เข้าหน้า login (เอา CSRF + cookie)
  let res = http.get('https://tsmct.com/login');

  // 2. ดึง CSRF token
  let csrf = res.html().find('input[name=_token]').first().attr('value');

  // 3. login (k6 จะเก็บ cookie ให้อัตโนมัติ)
  let loginRes = http.post('https://tsmct.com/login', {
    _token: csrf,
    username: 'tsmccoacha',
    password: 'tsmccoacha',
  });

  check(loginRes, {
    'login success': (r) =>
      r.status === 302 || r.status === 200,
  });

  // 4. เข้า dashboard (ต้อง auth แล้ว)
  let dashboard = http.get('https://tsmct.com/home');

  check(dashboard, {
    'dashboard loaded': (r) => r.status === 200,
  });

  sleep(1);
}