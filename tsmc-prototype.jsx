import React, { useState } from 'react';

const TSMC_LOGO = 'data:image/png;base64,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';
const TSMC_LOGO_SM = 'data:image/png;base64,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';
const DEPA_LOGO = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACQAAAAkCAIAAABuYg/PAAABCGlDQ1BJQ0MgUHJvZmlsZQAAeJxjYGA8wQAELAYMDLl5JUVB7k4KEZFRCuwPGBiBEAwSk4sLGHADoKpv1yBqL+viUYcLcKakFicD6Q9ArFIEtBxopAiQLZIOYWuA2EkQtg2IXV5SUAJkB4DYRSFBzkB2CpCtkY7ETkJiJxcUgdT3ANk2uTmlyQh3M/Ck5oUGA2kOIJZhKGYIYnBncAL5H6IkfxEDg8VXBgbmCQixpJkMDNtbGRgkbiHEVBYwMPC3MDBsO48QQ4RJQWJRIliIBYiZ0tIYGD4tZ2DgjWRgEL7AwMAVDQsIHG5TALvNnSEfCNMZchhSgSKeDHkMyQx6QJYRgwGDIYMZAKbWPz9HbOBQAAADRElEQVR42u1WTWhcZRQ9997v/cx/46RNMCUNJo1NLUUpWMGN4Ma6UPxDqKL7Lixd1IXdu5SCCEVc6MK6EoOIgl0VRBCyKdiIiG0tKZNpx7xkkpk3M+9733WRMZO2QSaGBgpzVo/3vvsO5957znvAAAMM8HCAaFdoAo8B6pOPdyjIGJx+y/e9vvh2RCaMRuxE0m8+9lSJ6H/3s4+69beHPsVXzFfnBSDmXh3fxy07nJkRdCzCgE+dSw/kZfYS+N9maT+KQETieYWRTRLpngMb18wEoslxblxljfDFRwYgERBhekomDsh/9Kh7W4JCYer5PsUxAaDZC2IXocv0+XkDEEBzP3nvnOR19d023F2oJlsmE6jtaNoBQGxMYRRpkqxV2YSAsp8nL0zqFaiTsMR+nl2jvbb8yZd4+TVq1/TdU+nKqsxfx7Fn7eQPvElCrz8EaDjyhMmW0zgyhVFNO82bv2T2H0ubkYQFG0dIbTj2ZGfpOhGzn48X5oK9h1zSNLnhpH7LRteu/GgOP2VtE14BUHJFvfStvPCKY1bnegtCgEqQD/fNNK5dTtaqmjQlMyR+jv1csrLg0k5QnlRnXRLHC3NJvSKZR9jPtaq/kvHZy4XF4bh2Qwy/+KpDDCicQgS+0IXPkNju2Ho+Iwmcbas6AGlrBc6yn3NJk8MimaBVnYdqGkfrh22zZrLl7PgzJlt27XpqLYCLs3r7T0EIMiAi28D4jB4+xBs7whtbmraWiY0/NMFeNhg+SH42WV1kEybRzc7SDdequyQOylMSliQsBkMTzrbI+K3qVVUHyRDh76X0pbe5VpHoDpoxTJ6/vmhuVZQIqvf4TNU2akH5Ma/0qDrrWvV27Q8yYbDvcb80RkSAsp+VoOCX9neiv1q3f5OwFOw9CHWus6pxzTl8eBbHj6e5IbQcnznL759LG40e2TaQGT0SjhzZOrcIAN44YbRO2sDl72RmWgBsDpQtfUZ3GZloI5e84pi/Z7xrauo9ZSZm2lPgaJ7bFf7gPUMgAMY8gK+MMAB8/6n5/Wd5+mg3MnirhN8WO92fecJIHd484S3eodefs82OMwKbbn9IfcIzdHTa26zygYNpt34OeHdoBhjgIcU/aO454Zhvlu4AAAAASUVORK5CYII=';

function cn(...classes) {
  return classes.filter(Boolean).join(' ');
}

/* ─── Tiny UI primitives ─── */
function Button({ className = '', children, variant = 'default', ...props }) {
  const base = 'inline-flex items-center justify-center rounded-xl px-4 py-2.5 text-sm font-medium transition-colors';
  const v = {
    default: 'bg-yellow-400 text-neutral-900 hover:bg-yellow-300',
    outline: 'border border-white/10 text-neutral-300 hover:bg-white/5',
    ghost: 'text-neutral-400 hover:text-white hover:bg-white/5',
  };
  return <button type="button" className={cn(base, v[variant] || v.default, className)} {...props}>{children}</button>;
}

function Badge({ className = '', children, variant = 'default' }) {
  const v = {
    default: 'bg-yellow-400/10 text-yellow-400 border-yellow-400/20',
    outline: 'border-white/10 text-neutral-400',
    muted: 'bg-white/5 text-neutral-400 border-white/8',
    success: 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
  };
  return <span className={cn('inline-flex items-center rounded-lg border px-2.5 py-0.5 text-[13px] font-medium', v[variant] || v.default, className)}>{children}</span>;
}

function Input({ className = '', ...props }) {
  return <input className={cn('h-10 w-full rounded-xl border border-white/8 bg-white/3 px-3.5 text-sm text-white outline-none placeholder:text-neutral-500 focus:border-yellow-400/40 transition-colors', className)} {...props} />;
}

function Textarea({ className = '', ...props }) {
  return <textarea className={cn('w-full rounded-xl border border-white/8 bg-white/3 px-3.5 py-2.5 text-sm text-white outline-none placeholder:text-neutral-500 focus:border-yellow-400/40 transition-colors', className)} {...props} />;
}

function Select({ className = '', children, ...props }) {
  return <select className={cn('h-10 w-full rounded-xl border border-white/8 bg-white/3 px-3.5 text-sm text-white outline-none focus:border-yellow-400/40', className)} {...props}>{children}</select>;
}

/* ─── Icons (simplified) ─── */
function Icon({ type, className = '' }) {
  const cls = cn('h-4 w-4', className);
  const s = "currentColor";
  const icons = {
    bell: <svg viewBox="0 0 24 24" className={cls}><path d="M12 2.5a5.5 5.5 0 0 1 5.5 5.5v3.25l1.8 2.7a.75.75 0 0 1-.63 1.15H5.33a.75.75 0 0 1-.63-1.15l1.8-2.7V8A5.5 5.5 0 0 1 12 2.5Z" fill={s} opacity=".15" stroke={s} strokeWidth="1.5"/><path d="M9.5 16.5a2.5 2.5 0 0 0 5 0" fill="none" stroke={s} strokeWidth="1.5" strokeLinecap="round"/></svg>,
    users: <svg viewBox="0 0 24 24" className={cls}><circle cx="9" cy="7.5" r="3.5" fill={s} opacity=".15" stroke={s} strokeWidth="1.5"/><path d="M2.5 19.5c0-3 3-5.5 6.5-5.5s6.5 2.5 6.5 5.5" fill="none" stroke={s} strokeWidth="1.5" strokeLinecap="round"/><circle cx="17.5" cy="8.5" r="2.5" fill="none" stroke={s} strokeWidth="1.5"/><path d="M17.5 14c2 .3 4 1.8 4 4" fill="none" stroke={s} strokeWidth="1.5" strokeLinecap="round"/></svg>,
    shield: <svg viewBox="0 0 24 24" className={cls}><path d="M12 2.5l8 3.5v5.5c0 5-3 8.5-8 10-5-1.5-8-5-8-10V6l8-3.5Z" fill={s} opacity=".15" stroke={s} strokeWidth="1.5"/><path d="m9 12.5 2 2 4-4.5" fill="none" stroke={s} strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"/></svg>,
    truck: <svg viewBox="0 0 24 24" className={cls}><rect x="2" y="6" width="12" height="9" rx="1.5" fill={s} opacity=".15" stroke={s} strokeWidth="1.5"/><path d="M14 9.5h3.5l3 3V15a1 1 0 0 1-1 1h-5.5" fill="none" stroke={s} strokeWidth="1.5"/><circle cx="7" cy="17.5" r="2" fill={s} opacity=".25" stroke={s} strokeWidth="1.5"/><circle cx="17" cy="17.5" r="2" fill={s} opacity=".25" stroke={s} strokeWidth="1.5"/></svg>,
    chart: <svg viewBox="0 0 24 24" className={cls}><rect x="3" y="12" width="4" height="8" rx="1" fill={s} opacity=".15" stroke={s} strokeWidth="1.5"/><rect x="10" y="7" width="4" height="13" rx="1" fill={s} opacity=".25" stroke={s} strokeWidth="1.5"/><rect x="17" y="3" width="4" height="17" rx="1" fill={s} opacity=".15" stroke={s} strokeWidth="1.5"/></svg>,
    clipboard: <svg viewBox="0 0 24 24" className={cls}><rect x="5" y="4" width="14" height="17" rx="2.5" fill={s} opacity=".12" stroke={s} strokeWidth="1.5"/><rect x="8" y="2" width="8" height="3.5" rx="1.5" fill={s} opacity=".25" stroke={s} strokeWidth="1.5"/><path d="m9 13 2 2 4-4.5" fill="none" stroke={s} strokeWidth="1.8" strokeLinecap="round" strokeLinejoin="round"/></svg>,
    file: <svg viewBox="0 0 24 24" className={cls}><path d="M6 2.5h8.5L19 7v13.5a1.5 1.5 0 0 1-1.5 1.5h-10A1.5 1.5 0 0 1 6 20.5v-18Z" fill={s} opacity=".12" stroke={s} strokeWidth="1.5"/><path d="M14 2.5v5h5" fill="none" stroke={s} strokeWidth="1.5" strokeLinejoin="round"/><path d="M9 13h6M9 16h4" fill="none" stroke={s} strokeWidth="1.5" strokeLinecap="round"/></svg>,
    send: <svg viewBox="0 0 24 24" className={cls}><path d="M3.5 11.5 21 3l-7 18-3-8-7.5-1.5Z" fill={s} opacity=".12" stroke={s} strokeWidth="1.5" strokeLinejoin="round"/><path d="M11 13 21 3" fill="none" stroke={s} strokeWidth="1.5"/></svg>,
    incident: <svg viewBox="0 0 24 24" className={cls}><path d="M12 3 2.5 20h19L12 3Z" fill={s} opacity=".12" stroke={s} strokeWidth="1.5" strokeLinejoin="round"/><path d="M12 9.5v4" stroke={s} strokeWidth="2" strokeLinecap="round" fill="none"/><circle cx="12" cy="16.5" r="1" fill={s}/></svg>,
    training: <svg viewBox="0 0 24 24" className={cls}><path d="m12 3 9.5 4-9.5 4L2.5 7 12 3Z" fill={s} opacity=".15" stroke={s} strokeWidth="1.5"/><path d="M6.5 9v5c0 2 2.5 3.5 5.5 3.5s5.5-1.5 5.5-3.5V9" fill="none" stroke={s} strokeWidth="1.5"/><path d="M21.5 7v5.5" stroke={s} strokeWidth="1.5" strokeLinecap="round" fill="none"/></svg>,
    car: <svg viewBox="0 0 24 24" className={cls}><path d="M4.5 14.5 7 8.5h10l2.5 6" fill={s} opacity=".12" stroke={s} strokeWidth="1.5"/><rect x="3" y="14" width="18" height="4.5" rx="1.5" fill={s} opacity=".08" stroke={s} strokeWidth="1.5"/><circle cx="7.5" cy="18.5" r="1.8" fill={s} opacity=".2" stroke={s} strokeWidth="1.5"/><circle cx="16.5" cy="18.5" r="1.8" fill={s} opacity=".2" stroke={s} strokeWidth="1.5"/></svg>,
    building: <svg viewBox="0 0 24 24" className={cls}><rect x="3" y="5" width="10" height="16" rx="1.5" fill={s} opacity=".12" stroke={s} strokeWidth="1.5"/><rect x="13" y="9" width="8" height="12" rx="1.5" fill={s} opacity=".08" stroke={s} strokeWidth="1.5"/><circle cx="7" cy="10" r=".8" fill={s}/><circle cx="10" cy="10" r=".8" fill={s}/><circle cx="7" cy="14" r=".8" fill={s}/><circle cx="10" cy="14" r=".8" fill={s}/><circle cx="16" cy="13" r=".8" fill={s}/><circle cx="16" cy="16" r=".8" fill={s}/></svg>,
    route: <svg viewBox="0 0 24 24" className={cls}><circle cx="6" cy="5" r="2.5" fill={s} opacity=".2" stroke={s} strokeWidth="1.5"/><circle cx="18" cy="19" r="2.5" fill={s} opacity=".2" stroke={s} strokeWidth="1.5"/><path d="M8.5 5h3a4 4 0 0 1 4 4v2a4 4 0 0 0 4 4h-4" fill="none" stroke={s} strokeWidth="1.5" strokeLinecap="round" strokeDasharray="3 2"/></svg>,
    chevron: <svg viewBox="0 0 24 24" fill="none" className={cls} stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><path d="m6 9 6 6 6-6"/></svg>,
    mail: <svg viewBox="0 0 24 24" className={cls}><rect x="3" y="5" width="18" height="14" rx="2.5" fill={s} opacity=".12" stroke={s} strokeWidth="1.5"/><path d="m4 7 8 5.5L20 7" fill="none" stroke={s} strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round"/></svg>,
    phone: <svg viewBox="0 0 24 24" className={cls}><path d="M6.5 3.5h4l1.5 4.5-2.5 1.5a13 13 0 0 0 5 5L16 12.5l4.5 1.5v4a2 2 0 0 1-2 2A16 16 0 0 1 4 5.5a2 2 0 0 1 2-2h.5Z" fill={s} opacity=".12" stroke={s} strokeWidth="1.5"/></svg>,
    settings: <svg viewBox="0 0 24 24" className={cls}><circle cx="12" cy="12" r="3" fill={s} opacity=".2" stroke={s} strokeWidth="1.5"/><path d="M12 2v2.5M12 19.5V22M22 12h-2.5M4.5 12H2M19.1 4.9l-1.8 1.8M6.7 17.3l-1.8 1.8M19.1 19.1l-1.8-1.8M6.7 6.7 4.9 4.9" fill="none" stroke={s} strokeWidth="1.5" strokeLinecap="round"/></svg>,
    check: <svg viewBox="0 0 24 24" className={cls}><circle cx="12" cy="12" r="9.5" fill={s} opacity=".1" stroke={s} strokeWidth="1.5"/><path d="m8 12 3 3 5.5-6" fill="none" stroke={s} strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"/></svg>,
    arrowRight: <svg viewBox="0 0 24 24" fill="none" className={cls} stroke="currentColor" strokeWidth="1.8" strokeLinecap="round" strokeLinejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>,
    form: <svg viewBox="0 0 24 24" className={cls}><rect x="4" y="2.5" width="16" height="19" rx="2.5" fill={s} opacity=".12" stroke={s} strokeWidth="1.5"/><path d="M8 8h8M8 12h8M8 16h5" fill="none" stroke={s} strokeWidth="1.5" strokeLinecap="round"/><circle cx="17" cy="17" r="3.5" fill={s} opacity=".25" stroke={s} strokeWidth="1.5"/><path d="m15.5 17 1 1 2-2.5" fill="none" stroke={s} strokeWidth="1.3" strokeLinecap="round" strokeLinejoin="round"/></svg>,
    lock: <svg viewBox="0 0 24 24" className={cls}><rect x="4.5" y="10.5" width="15" height="11" rx="2.5" fill={s} opacity=".12" stroke={s} strokeWidth="1.5"/><path d="M8 10.5V7a4 4 0 0 1 8 0v3.5" fill="none" stroke={s} strokeWidth="1.5"/><circle cx="12" cy="15.5" r="1.5" fill={s}/></svg>,
    clock: <svg viewBox="0 0 24 24" className={cls}><circle cx="12" cy="12" r="9.5" fill={s} opacity=".1" stroke={s} strokeWidth="1.5"/><path d="M12 6.5v6l4 2.5" fill="none" stroke={s} strokeWidth="1.8" strokeLinecap="round" strokeLinejoin="round"/></svg>,
    logout: <svg viewBox="0 0 24 24" className={cls}><path d="M15 4h3.5A1.5 1.5 0 0 1 20 5.5v13a1.5 1.5 0 0 1-1.5 1.5H15" fill="none" stroke={s} strokeWidth="1.5" strokeLinecap="round"/><path d="M10 12h10M17 8.5l3.5 3.5-3.5 3.5" fill="none" stroke={s} strokeWidth="1.8" strokeLinecap="round" strokeLinejoin="round"/><rect x="3.5" y="3.5" width="8" height="17" rx="2" fill={s} opacity=".08" stroke={s} strokeWidth="1.5"/></svg>,
    panelLeft: <svg viewBox="0 0 24 24" className={cls}><rect x="3" y="3" width="18" height="18" rx="2.5" fill={s} opacity=".08" stroke={s} strokeWidth="1.5"/><path d="M9 3v18" stroke={s} strokeWidth="1.5"/><rect x="4" y="4" width="4" height="16" rx="1" fill={s} opacity=".1"/></svg>,
  };
  return icons[type] || <svg viewBox="0 0 24 24" className={cls}><circle cx="12" cy="12" r="9" fill={s} opacity=".1" stroke={s} strokeWidth="1.5"/></svg>;
}

/* ─── Data ─── */
const roleMeta = {
  tsm: { label: 'เจ้าหน้าที่ TSM', icon: 'shield' },
  manager: { label: 'เจ้าของกิจการ', icon: 'building' },
  fleet: { label: 'ผู้ขับรถ', icon: 'truck' },
  other: { label: 'อื่นๆ', icon: 'users' },
};

const roleNavigation = {
  tsm: ['dashboard', 'dailyOps', 'assignWork', 'documentsForms', 'safetyAnalysis', 'reports', 'orgData', 'knowledge'],
  manager: ['dashboard', 'assignWork', 'tracking', 'fleetPeople', 'reports', 'knowledge'],
  fleet: ['dashboard', 'myWork', 'myForms', 'myVehicle', 'myHistory', 'knowledge'],
  other: ['dashboard', 'myForms', 'reports', 'knowledge'],
};

const menuCatalog = {
  dashboard: { key: 'dashboard', label: 'หน้าหลัก', icon: 'chart' },
  dailyOps: { key: 'dailyOps', label: 'งานประจำวัน', icon: 'clipboard' },
  assignWork: { key: 'assignWork', label: 'จ่ายงาน', icon: 'send' },
  documentsForms: { key: 'documentsForms', label: 'ทำเอกสาร', icon: 'form' },
  safetyAnalysis: { key: 'safetyAnalysis', label: 'วิเคราะห์ 5 ด้าน', icon: 'shield' },
  reports: { key: 'reports', label: 'รายงาน', icon: 'send' },
  orgData: { key: 'orgData', label: 'จัดการข้อมูล', icon: 'building' },
  knowledge: { key: 'knowledge', label: 'ความรู้ออนไลน์', icon: 'training' },
  tracking: { key: 'tracking', label: 'ติดตามงาน', icon: 'route' },
  fleetPeople: { key: 'fleetPeople', label: 'รถและบุคลากร', icon: 'truck' },
  myWork: { key: 'myWork', label: 'งานของฉัน', icon: 'clipboard' },
  myForms: { key: 'myForms', label: 'แบบฟอร์ม', icon: 'form' },
  myVehicle: { key: 'myVehicle', label: 'รถของฉัน', icon: 'car' },
  myHistory: { key: 'myHistory', label: 'ประวัติของฉัน', icon: 'clock' },
};

const pageMeta = {
  dashboard: { title: 'Dashboard', hero: 'ภาพรวมการปฏิบัติงาน', description: 'หน้าเริ่มต้นแสดงความพร้อมระบบ งานวันนี้ งานค้าง แจ้งเตือน และ quick actions', quick: ['ดูงานวันนี้', 'ดูงานค้าง', 'ดูแจ้งเตือน', 'Quick Action'], list: ['รวมภาพรวมของบทบาทในหน้าเดียว', 'แสดง progress รายวันและรายไตรมาส', 'เชื่อมไปยังเมนูงานจริงได้ทันที', 'รองรับการติดตามภารกิจให้ครบ 100%'] },
  dailyOps: { title: 'งานประจำวัน', hero: 'งานประจำวัน', description: 'ต้องดำเนินการ • Checklist • สถานะรถ/ผู้ขับ', quick: ['เริ่มงาน', 'Check-in', 'ตรวจความพร้อมรถ', 'จัดการเหตุฉุกเฉิน'], list: ['บันทึกเวลาทำงาน: เริ่มงาน / Check-in / จบงาน', 'การจัดการรถ: บรรทุก / โดยสาร / แผนบำรุงรักษา', 'การจัดการผู้ขับรถ: ROLLCALL / ฝึกอบรม / สุขภาพ', 'การจัดการเดินรถและเหตุฉุกเฉิน'] },
  documentsForms: { title: 'ทำเอกสาร', hero: 'ทำเอกสาร', description: 'รวมเอกสาร 5 หมวด ทะเบียนเอกสาร จัดการแบบฟอร์ม และแบบฟอร์มย่อย', quick: ['ทำเอกสาร 5 หมวด', 'ทะเบียนเอกสาร', 'จัดการแบบฟอร์ม', 'แบบฟอร์มย่อย'], list: ['ทะเบียนเอกสาร 5 หมวด', 'จัดการแบบฟอร์มตามหมวดงาน', 'แบบฟอร์มย่อย เช่น ตรวจแอลกอฮอล์ ตรวจสารเสพติด', 'รองรับฟอร์มมาตรฐานและฟอร์มเฉพาะบริษัท'] },
  reports: { title: 'รายงาน', hero: 'รายงานและการส่งออกข้อมูล', description: 'รวมรายงานหลักของทุกบทบาท เช่น Log Book รายงานผลส่งกรม BA Report และ Export PDF/Excel', quick: ['ค้นหารายงาน', 'Log Book', 'รายงานส่งกรม', 'Export PDF/Excel'], list: ['รายงานสรุปผล รายงานรถ ผู้ขับรถ บำรุงรักษา', 'รายงานผลส่งกรมใน flow เดียว', 'ดาวน์โหลด PDF และ Excel', 'เหมาะกับทุกบทบาทในมุมมองที่ต่างกัน'] },
  orgData: { title: 'ข้อมูลองค์กร', hero: 'ข้อมูลองค์กรและการตั้งค่า', description: 'รวมข้อมูลบริษัท รถ ผู้ใช้ ตำแหน่ง สิทธิ์ ผู้ประจำรถ การนำเข้าข้อมูล และโปรไฟล์', quick: ['ข้อมูลบริษัท', 'ข้อมูลรถ', 'ผู้ใช้ทั้งหมด', 'สิทธิ์การเข้าถึง'], list: ['จัดการข้อมูลบริษัท รถ ผู้ใช้ และตำแหน่ง', 'กำหนดสิทธิ์และผู้ประจำรถ', 'นำเข้าข้อมูลรถและผู้ใช้', 'โปรไฟล์และประวัติการเข้าใช้'] },
  knowledge: { title: 'ความรู้ออนไลน์', hero: 'ศูนย์การเรียนรู้', description: 'รวม Hub Training Center คู่มือ ประกาศ องค์ความรู้บริษัท และลิงก์สื่อความรู้', quick: ['Training Center', 'คู่มือการใช้งาน', 'ประกาศ/ข่าวสาร', 'องค์ความรู้'], list: ['คู่มือคนขับ คู่มือผู้ใช้ และมาตรฐาน', 'ข่าวสารและประกาศภายใน', 'องค์ความรู้บริษัทและลิงก์สื่อ', 'เชื่อมกับ Training'] },
  tracking: { title: 'ติดตามงาน', hero: 'ติดตามสถานะการดำเนินงาน', description: 'ติดตามงานวันนี้ งานค้าง งานเกินกำหนด รถ ผู้ขับ และเหตุผิดปกติ', quick: ['สถานะงานวันนี้', 'งานยังไม่ครบ', 'งานเกินกำหนด', 'เหตุผิดปกติ'], list: ['สถานะงานวันนี้และงานเกินกำหนด', 'ติดตามรถและผู้ขับ', 'เหตุผิดปกติและเหตุฉุกเฉิน', 'ภาพรวมธุรกิจจริง'] },
  fleetPeople: { title: 'รถและบุคลากร', hero: 'รถและบุคลากร', description: 'ข้อมูลรถ สถานะ บำรุงรักษา Log Book ผู้ประจำรถ แผนฝึกอบรม และสุขภาพ', quick: ['ข้อมูลรถ', 'สถานะรถ', 'บำรุงรักษา', 'ผู้ประจำรถ'], list: ['ข้อมูลรถและสถานะจากมุมมองผู้บริหาร', 'งานบำรุงรักษาและ Log Book', 'ผู้ประจำรถ แผนฝึกอบรม สุขภาพ', 'ติดตามทรัพยากรหลักของกิจการ'] },
  myWork: { title: 'งานของฉัน', hero: 'งานของฉัน', description: 'ติดตามงานตั้งแต่เริ่มงาน Check-in ระหว่างงาน และจบงาน', quick: ['เริ่มงาน', 'Check-in', 'ระหว่างงาน', 'จบงาน'], list: ['งานวันนี้และสถานะปัจจุบัน', 'เริ่มงานและจบงานอย่างชัดเจน', 'Tracking ระหว่างงาน', 'เชื่อมต่อกับ progress'] },
  myForms: { title: 'แบบฟอร์มที่ต้องทำ', hero: 'แบบฟอร์มที่ต้องทำ', description: 'ROLLCALL ก่อน/ระหว่าง/หลังปฏิบัติงาน ตรวจรถ สุขภาพ และแจ้งเหตุฉุกเฉิน', quick: ['ROLLCALL ก่อนงาน', 'ROLLCALL ระหว่างงาน', 'ตรวจความพร้อมรถ', 'แจ้งเหตุฉุกเฉิน'], list: ['แบบฟอร์มทั้งหมดในที่เดียว', 'แยกก่อนงาน ระหว่างงาน หลังงาน', 'ตรวจสุขภาพ / ความล้า', 'แจ้งเหตุฉุกเฉิน'] },
  myVehicle: { title: 'รถของฉัน', hero: 'รถของฉัน', description: 'ข้อมูลรถที่รับผิดชอบ สถานะ แจ้งปัญหา และ Log', quick: ['ข้อมูลรถ', 'สถานะรถ', 'แจ้งปัญหารถ', 'ดู Log'], list: ['รถที่รับผิดชอบชัดเจน', 'สถานะรถและปัญหาจากหน้าเดียว', 'แจ้งปัญหาและดูประวัติ', 'เชื่อมกับงานและแบบฟอร์ม'] },
  myHistory: { title: 'ประวัติของฉัน', hero: 'ประวัติของฉัน', description: 'ประวัติฟอร์ม เวลางาน Check-in และการแจ้งเหตุ', quick: ['ประวัติฟอร์ม', 'ประวัติเวลางาน', 'ประวัติ Check-in', 'ประวัติแจ้งเหตุ'], list: ['ประวัติทั้งหมดในที่เดียว', 'เวลางานและ check-in ย้อนหลัง', 'ประวัติแจ้งเหตุชัดเจน', 'หลักฐานการทำงาน'] },
  assignWork: { title: 'จ่ายงาน', hero: 'จ่ายงานให้ทีม', description: 'มอบหมายฟอร์มให้ผู้ใช้แต่ละคน ส่ง QR Code/ลิงก์ผ่าน LINE ติดตามสถานะ', quick: ['เลือกคน', 'เลือกฟอร์ม', 'ส่ง QR Code', 'ติดตามสถานะ'], list: ['เลือกผู้รับงาน → เลือกฟอร์ม → จ่ายงาน', 'สร้าง QR Code + ลิงก์อัตโนมัติ', 'แชร์ผ่าน LINE ได้ทันที', 'ติดตามสถานะงานที่จ่ายแล้ว'] },
  safetyAnalysis: { title: 'วิเคราะห์ 5 ด้าน', hero: 'วิเคราะห์ความปลอดภัย 5 ด้าน', description: 'ภาพรวมคะแนน 5 ด้านตามกฎหมาย TSM: การจัดการรถ ผู้ขับ เดินรถ บรรทุก วิเคราะห์', quick: ['ภาพรวม 5 ด้าน', 'KPI แต่ละด้าน', 'แนวโน้ม', 'สรุปผล'], list: ['Gauge + Radar แสดงคะแนนรวม', 'KPI แยกรายด้าน + กราฟเส้นรายเดือน', 'แจ้งเตือนด้านที่ต้องปรับปรุง', 'ข้อมูลจาก 18 ฟอร์มประมวลผลอัตโนมัติ'] },
};

const roleKpis = {
  manager: [
    { label: 'ภารกิจ', value: '18', unit: 'งาน', icon: 'clipboard' },
    { label: 'ความเสี่ยง', value: '5', unit: 'ประเด็น', icon: 'incident' },
    { label: 'Compliance', value: '87', unit: '%', icon: 'chart' },
    { label: 'รายงานส่งกรม', value: '3', unit: 'ชุด', icon: 'send' },
  ],
  tsm: [
    { label: 'งานวันนี้', value: '24', unit: 'งาน', icon: 'clipboard' },
    { label: 'ภารกิจ', value: '11', unit: 'งาน', icon: 'incident' },
    { label: 'Progress วัน', value: '72', unit: '%', icon: 'chart' },
    { label: 'Progress ไตรมาส', value: '48', unit: '%', icon: 'send' },
  ],
  fleet: [
    { label: 'งานวันนี้', value: '3', unit: 'เที่ยว', icon: 'clipboard' },
    { label: 'รถรับผิดชอบ', value: '1', unit: 'คัน', icon: 'car' },
    { label: 'ฟอร์มค้าง', value: '4', unit: 'ฟอร์ม', icon: 'file' },
    { label: 'Progress', value: '64', unit: '%', icon: 'chart' },
  ],
  other: [
    { label: 'ฟอร์มที่ได้รับ', value: '5', unit: 'รายการ', icon: 'file' },
    { label: 'ทำแล้ว', value: '3', unit: 'รายการ', icon: 'check' },
    { label: 'คะแนน', value: '180', unit: 'คะแนน', icon: 'chart' },
    { label: 'Progress', value: '60', unit: '%', icon: 'chart' },
  ],
};

const roleProfiles = {
  manager: { name: 'Owner', role: 'เจ้าของกิจการ', email: 'owner@tsmc.co.th', phone: '08X-XXX-1100', dept: 'Executive Office' },
  tsm: { name: 'Somchai', role: 'เจ้าหน้าที่ TSM', email: 'somchai@tsmc.co.th', phone: '08X-XXX-2200', dept: 'Transport Safety Center' },
  fleet: { name: 'Driver', role: 'คนขับรถ', email: 'driver@tsmc.co.th', phone: '08X-XXX-3300', dept: 'Transport Operations' },
  other: { name: 'สุภาพร', role: 'เจ้าหน้าที่ทั่วไป', email: 'supaporn@tsmc.co.th', phone: '08X-XXX-4400', dept: 'บัญชี' },
};

/* ─── Journey data ─── */
const roleJourneys = {
  manager: {
    title: 'เส้นทางข้อมูลเพื่อระบบพร้อมใช้งาน 100%',
    phases: [
      { title: 'ข้อมูลตั้งต้น', steps: [{ label: 'ข้อมูลบริษัท', done: true }, { label: 'ผู้ใช้ทั้งหมด', done: true }, { label: 'ข้อมูลรถ', done: false }, { label: 'ข้อมูลคนขับ', done: false }] },
      { title: 'งานประจำวัน', steps: [{ label: 'ตรวจงานค้าง', done: true }, { label: 'อนุมัติงาน', done: false }, { label: 'ติดตามประเด็น', done: false }, { label: 'ปิดภารกิจ', done: false }] },
    ],
  },
  tsm: {
    title: 'เส้นทางข้อมูลเพื่อระบบพร้อมใช้งาน 100%',
    phases: [
      { title: 'ข้อมูลตั้งต้น', steps: [{ label: 'ตั้งค่าบริษัท', done: true }, { label: 'เพิ่มรถ', done: true }, { label: 'เพิ่มคน', done: false }, { label: 'กำหนดสิทธิ์', done: false }, { label: 'ผูกผู้ประจำรถ', done: false }, { label: 'เปิดแบบฟอร์ม', done: false }, { label: 'ระบบพร้อม', done: false }] },
      { title: 'ปฏิบัติงานจริง', steps: [{ label: 'เริ่มงาน', done: true }, { label: 'ฟอร์มก่อนงาน', done: true }, { label: 'ติดตามระหว่างงาน', done: false }, { label: 'บันทึกเหตุ', done: false }, { label: 'ฟอร์มหลังงาน', done: false }, { label: 'เข้าทะเบียน', done: false }] },
      { title: 'รายงานผลกรม', steps: [{ label: 'ทำข้อมูล', done: false }, { label: 'สรุปผล', done: false }, { label: 'ออกรายงาน', done: false }, { label: 'ดาวน์โหลด', done: false }] },
    ],
  },
  fleet: {
    title: 'เส้นทางข้อมูลเพื่อระบบพร้อมใช้งาน 100%',
    phases: [
      { title: 'ความพร้อมก่อนงาน', steps: [{ label: 'ตรวจรถ', done: true }, { label: 'ตรวจเอกสาร', done: true }, { label: 'ตรวจสุขภาพ', done: false }, { label: 'พร้อมเริ่มงาน', done: false }] },
      { title: 'งานประจำวัน', steps: [{ label: 'เริ่มงาน', done: true }, { label: 'Check-in', done: false }, { label: 'ทำแบบฟอร์ม', done: false }, { label: 'จบงาน', done: false }] },
    ],
  },
  other: {
    title: 'เส้นทางข้อมูลเพื่อระบบพร้อมใช้งาน 100%',
    phases: [
      { title: 'งานที่ได้รับ', steps: [{ label: 'ดูงาน', done: true }, { label: 'ทำฟอร์ม', done: false }, { label: 'ส่งงาน', done: false }] },
    ],
  },
};

const treeStructures = {
  manager: [
    { title: 'ภาพรวมธุรกิจ', items: ['Dashboard ผู้บริหาร', 'Compliance Overview', 'KPI หลัก', 'ภารกิจ', 'ความเสี่ยงสำคัญ'] },
    { title: 'ติดตามงาน', items: ['สถานะงานวันนี้', 'งานเกินกำหนด', 'ติดตามรถ', 'ติดตามผู้ขับ', 'เหตุผิดปกติ'] },
    { title: 'รายงาน', items: ['รายงานสรุปผล', 'BA Report', 'รายงานรถ', 'รายงานส่งกรม', 'Export PDF/Excel'] },
    { title: 'รถและบุคลากร', items: ['ข้อมูลรถ', 'บำรุงรักษา', 'Log Book', 'ผู้ประจำรถ', 'แผนฝึกอบรม'] },
  ],
  tsm: [
    { title: 'หน้าหลัก', items: ['ความพร้อมระบบ', 'งานวันนี้', 'ภารกิจ', 'แจ้งเตือน', 'Progress', 'Quick Actions'] },
    { title: 'งานประจำวัน', items: ['บันทึกเวลา', 'การจัดการรถ', 'การจัดการผู้ขับรถ', 'การจัดการเดินรถ', 'บรรทุกและโดยสาร', 'วิเคราะห์ผล'] },
    { title: 'เอกสารและแบบฟอร์ม', items: ['เอกสาร 5 หมวด', 'ทะเบียนเอกสาร', 'จัดการแบบฟอร์ม', 'แบบฟอร์มย่อย'] },
    { title: 'รายงาน', items: ['ค้นหารายงาน', 'Log Book', 'รายงานส่งกรม', 'BA Report', 'Export'] },
    { title: 'ข้อมูลองค์กร', items: ['บริษัท', 'รถ', 'ผู้ใช้', 'สิทธิ์', 'นำเข้าข้อมูล', 'โปรไฟล์'] },
  ],
  fleet: [
    { title: 'หน้าหลัก', items: ['งานวันนี้', 'สถานะงาน', 'รถที่รับผิดชอบ', 'แจ้งเตือน'] },
    { title: 'งานของฉัน', items: ['เริ่มงาน', 'Check-in / Tracking', 'ระหว่างงาน', 'จบงาน'] },
    { title: 'แบบฟอร์ม', items: ['ROLLCALL ก่อน/ระหว่าง/หลัง', 'ตรวจรถ', 'ตรวจสุขภาพ', 'แจ้งเหตุ'] },
    { title: 'รถของฉัน', items: ['ข้อมูลรถ', 'สถานะ', 'แจ้งปัญหา', 'Log'] },
    { title: 'ประวัติ', items: ['ฟอร์ม', 'เวลางาน', 'Check-in', 'แจ้งเหตุ'] },
  ],
  other: [
    { title: 'หน้าหลัก', items: ['งานที่ได้รับ', 'สถานะ', 'แจ้งเตือน'] },
    { title: 'แบบฟอร์ม', items: ['ฟอร์มที่ได้รับมอบหมาย'] },
    { title: 'รายงาน', items: ['ประวัติฟอร์ม'] },
  ],
};


/* ═══════════════════════════════════════════
   LOGIN SCREEN — original design: left promo 70% + right form 30%
   ═══════════════════════════════════════════ */
function LoginScreen({ onEnter }) {
  const [mode, setMode] = useState('login');

  return (
    <div className="h-screen bg-[#071020] text-white flex flex-col lg:flex-row overflow-hidden">
      {/* ══ LEFT: Promotional (hidden on mobile) ══ */}
      <div className="hidden lg:flex flex-col justify-between relative overflow-hidden" style={{width:'70%'}}>
        {/* Background gradient */}
        <div style={{position:'absolute',inset:0,background:'linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%)'}} />
        <div style={{position:'absolute',inset:0,background:'linear-gradient(to top, rgba(15,23,42,0.95) 0%, transparent 50%)'}} />

        {/* Content */}
        <div className="relative z-10 p-10 lg:p-14 flex flex-col justify-between h-full">
          {/* Top logos */}
          <div className="flex items-center gap-6">
            <div className="flex items-center gap-3">
              <img src={TSMC_LOGO} alt="TSMC" style={{width:44,height:52,objectFit:'contain',filter:'drop-shadow(0 2px 8px rgba(251,191,36,0.4))'}}/>
              <div className="h-10 w-px" style={{background:'rgba(255,255,255,0.1)'}}/>
              <img src={DEPA_LOGO} alt="depa" style={{width:36,height:36,borderRadius:8,objectFit:'contain'}}/>
              <div>
                <p className="text-lg font-bold tracking-tight text-white">TSMC <span className="text-yellow-400 text-sm">x</span> <span className="text-sm font-medium text-neutral-400">depa</span></p>
                <p className="text-[13px] text-neutral-500">Transport Safety Management Center</p>
              </div>
            </div>
            <div className="flex items-center gap-2">
              <div className="rounded-lg px-2.5 py-1" style={{background:'rgba(251,191,36,0.08)',border:'1px solid rgba(251,191,36,0.15)'}}><span className="text-[13px] text-yellow-400 font-bold">ISO 29110</span></div>
              <div className="rounded-lg px-2.5 py-1" style={{background:'rgba(52,211,153,0.08)',border:'1px solid rgba(52,211,153,0.15)'}}><span className="text-[13px] text-emerald-400 font-bold">dSURE</span></div>
            </div>
          </div>

          {/* Center text */}
          <div className="max-w-xl">
            <p className="text-sm text-yellow-400 font-bold mb-3 tracking-wider">TRANSPORT SAFETY MANAGEMENT CENTER</p>
            <h1 className="text-3xl lg:text-4xl font-bold leading-tight mb-3">
              <span className="text-neutral-300">"ความปลอดภัยไม่ใช่ต้นทุน</span><br/><span className="text-yellow-400">แต่คือการลงทุนที่คุ้มค่าที่สุด"</span>
            </h1>
            <p className="text-sm text-neutral-500 italic mb-6">Safety is not a cost — it is the best investment.</p>
            <div className="space-y-2">
              {[
                {icon:'check',text:'กดเลือก ไม่ต้องพิมพ์ — กรอกฟอร์ม 92 ข้อภายใน 2 นาที',cl:'#34D399'},
                {icon:'chart',text:'วิเคราะห์ 5 ด้าน อัตโนมัติ — คะแนนคำนวณจาก data จริง',cl:'#60A5FA'},
                {icon:'send',text:'ส่งรายงานกรมขนส่งฯ ได้ทันที — ภาคสมัครใจ + ภาคบังคับ',cl:'#FBBF24'},
                {icon:'shield',text:'ตรงตามประกาศกรมฯ พ.ศ. 2564 — หน้าที่ TSM ครบ 5 ด้าน',cl:'#A78BFA'},
              ].map((f,i) => (
                <div key={i} className="flex items-center gap-3 px-3 py-2 rounded-xl" style={{background:'rgba(255,255,255,0.03)',border:'1px solid rgba(255,255,255,0.05)'}}>
                  <div className="w-6 h-6 rounded-md flex items-center justify-center shrink-0" style={{background:f.cl+'15'}}><Icon type={f.icon} className="h-3 w-3" style={{color:f.cl}}/></div>
                  <p className="text-sm text-neutral-300">{f.text}</p>
                </div>
              ))}
            </div>
          </div>

          {/* Bottom stats + depa badge */}
          <div>
            <div className="grid grid-cols-3 gap-4 mb-6">
              {[
                { n:'17', l:'แบบฟอร์ม', s:'ครบตามกฎหมาย' },
                { n:'5', l:'ด้านความปลอดภัย', s:'วิเคราะห์อัตโนมัติ' },
                { n:'4', l:'บทบาทผู้ใช้', s:'TSM/Owner/Driver/อื่นๆ' },
              ].map((s,i) => (
                <div key={i} className="rounded-xl bg-white/5 border border-white/8 p-4">
                  <p className="text-3xl font-black text-yellow-400">{s.n}</p>
                  <p className="text-sm font-medium text-white mt-1">{s.l}</p>
                  <p className="text-[13px] text-neutral-500">{s.s}</p>
                </div>
              ))}
            </div>
            <div className="rounded-2xl p-3 flex items-center gap-3" style={{background:'rgba(255,255,255,0.03)',border:'1px solid rgba(251,191,36,0.1)'}}>
              <img src={DEPA_LOGO} alt="depa" style={{width:32,height:32,borderRadius:8}}/>
              <div className="flex-1">
                <p className="text-sm font-bold text-white">มาตรฐาน ISO 29110 + dSURE โดย depa</p>
                <p className="text-[13px] text-neutral-500">สำนักงานส่งเสริมเศรษฐกิจดิจิทัล · บัญชีบริการดิจิทัล</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      {/* ══ RIGHT: Login Form (full on mobile, 30% on desktop) ══ */}
      <div className="flex items-center justify-center bg-[#0d1a2e] relative w-full lg:w-[30%] min-h-screen">
        <div className="relative z-10 w-full max-w-sm px-6 sm:px-8">
          {mode === 'login' ? (
            <div className="w-full">
              {/* Logo */}
              <div className="flex justify-center mb-6">
                <div className="h-14 w-14 rounded-2xl bg-yellow-400 flex items-center justify-center">
                  <Icon type="shield" className="text-neutral-900 h-5 w-5" />
                </div>
              </div>
              <h2 className="text-2xl font-bold text-white text-center mb-1">ยินดีต้อนรับกลับมา</h2>
              <p className="text-base text-neutral-400 text-center mb-6">กรุณาเข้าสู่ระบบเพื่อดำเนินการต่อ</p>

              <div className="space-y-4 mb-5">
                <div>
                  <label className="text-sm font-medium text-neutral-300 mb-1.5 block">อีเมล</label>
                  <input className="h-14 w-full rounded-xl border border-yellow-400/15 bg-white/5 px-4 text-lg text-white outline-none placeholder:text-neutral-500 focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition" placeholder="your@email.com" />
                </div>
                <div>
                  <label className="text-sm font-medium text-neutral-300 mb-1.5 block">รหัสผ่าน</label>
                  <input type="password" className="h-14 w-full rounded-xl border border-yellow-400/15 bg-white/5 px-4 text-lg text-white outline-none placeholder:text-neutral-500 focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition" placeholder="••••••••" />
                  <div className="flex items-center justify-between mt-2">
                    <label className="flex items-center gap-2 cursor-pointer select-none">
                      <input type="checkbox" defaultChecked className="w-4 h-4 rounded border-neutral-600 bg-white/5 accent-yellow-400 cursor-pointer" />
                      <span className="text-sm text-neutral-400">จดจำฉัน</span>
                    </label>
                    <button className="text-sm text-yellow-400 hover:text-yellow-300 cursor-pointer font-medium">ลืมรหัสผ่าน?</button>
                  </div>
                </div>
              </div>

              <button onClick={onEnter} className="w-full h-14 rounded-xl bg-yellow-400 text-neutral-900 text-lg font-bold hover:bg-yellow-300 transition cursor-pointer mb-4">เข้าสู่ระบบ</button>

              <div className="flex items-center gap-3 mb-4">
                <div className="flex-1 h-px bg-white/10" /><span className="text-sm text-neutral-500">หรือ</span><div className="flex-1 h-px bg-white/10" />
              </div>

              <button className="w-full h-12 rounded-xl border border-white/10 text-neutral-300 text-base font-medium hover:bg-white/5 transition cursor-pointer flex items-center justify-center gap-2 mb-6">
                <span className="text-lg">G</span> เข้าสู่ระบบด้วย Google
              </button>

              <p className="text-center text-sm text-neutral-500">
                ยังไม่มีบัญชี? <button onClick={() => setMode('register')} className="text-yellow-400 font-semibold hover:underline cursor-pointer">สมัครสมาชิกฟรี</button>
              </p>
            </div>
          ) : (
            <div className="w-full">
              <div className="flex justify-center mb-6">
                <div className="h-14 w-14 rounded-2xl bg-yellow-400 flex items-center justify-center">
                  <Icon type="shield" className="text-neutral-900 h-6 w-6" />
                </div>
              </div>
              <h2 className="text-2xl font-bold text-white text-center mb-1">สร้างบัญชีใหม่</h2>
              <p className="text-base text-neutral-400 text-center mb-6">กรอกข้อมูลเพื่อเริ่มใช้งาน TSMC</p>

              <div className="space-y-4 mb-5">
                <div className="grid grid-cols-2 gap-3">
                  <div><label className="text-sm font-medium text-neutral-300 mb-1.5 block">ชื่อ-นามสกุล</label><input className="h-12 w-full rounded-xl border border-yellow-400/15 bg-white/5 px-3 text-base text-white outline-none focus:border-yellow-400 transition" placeholder="ชื่อ-นามสกุล" /></div>
                  <div><label className="text-sm font-medium text-neutral-300 mb-1.5 block">บริษัท</label><input className="h-12 w-full rounded-xl border border-yellow-400/15 bg-white/5 px-3 text-base text-white outline-none focus:border-yellow-400 transition" placeholder="ชื่อบริษัท" /></div>
                </div>
                <div><label className="text-sm font-medium text-neutral-300 mb-1.5 block">อีเมล</label><input className="h-12 w-full rounded-xl border border-yellow-400/15 bg-white/5 px-3 text-base text-white outline-none focus:border-yellow-400 transition" placeholder="email@company.com" /></div>
                <div><label className="text-sm font-medium text-neutral-300 mb-1.5 block">เบอร์โทร</label><input className="h-12 w-full rounded-xl border border-yellow-400/15 bg-white/5 px-3 text-base text-white outline-none focus:border-yellow-400 transition" placeholder="08X-XXX-XXXX" /></div>
                <div className="grid grid-cols-2 gap-3">
                  <div><label className="text-sm font-medium text-neutral-300 mb-1.5 block">รหัสผ่าน</label><input type="password" className="h-12 w-full rounded-xl border border-yellow-400/15 bg-white/5 px-3 text-base text-white outline-none focus:border-yellow-400 transition" placeholder="••••••••" /></div>
                  <div><label className="text-sm font-medium text-neutral-300 mb-1.5 block">ยืนยัน</label><input type="password" className="h-12 w-full rounded-xl border border-yellow-400/15 bg-white/5 px-3 text-base text-white outline-none focus:border-yellow-400 transition" placeholder="••••••••" /></div>
                </div>
              </div>

              <button onClick={onEnter} className="w-full h-14 rounded-xl bg-yellow-400 text-neutral-900 text-lg font-bold hover:bg-yellow-300 transition cursor-pointer mb-6">ลงทะเบียนใช้งาน</button>
              <p className="text-center text-sm text-neutral-500">มีบัญชีอยู่แล้ว? <button onClick={() => setMode('login')} className="text-yellow-400 font-semibold hover:underline cursor-pointer">เข้าสู่ระบบ</button></p>
            </div>
          )}
        </div>
      </div>
    </div>
  );
}


/* ═══════════════════════════════════════════
   SIDEBAR — clean, no overflow icons
   ═══════════════════════════════════════════ */
function Sidebar({ role, activeKey, onChange, recentActions, open, onToggle }) {
  const items = roleNavigation[role];
  const recents = (recentActions || []).slice(0, 5);

  // ═══ Collapsed: icon-only sidebar ═══
  if (!open) {
    return (
      <aside onClick={onToggle} className="flex w-16 shrink-0 flex-col items-center border-r border-white/5 bg-[#0a1628]/80 py-3 gap-1.5 cursor-pointer hover:bg-[#0f1d32] transition-colors select-none" title="กดเพื่อเปิดเมนู">
        <div className="mb-2">
          <img src={TSMC_LOGO_SM} alt="TSMC" style={{width:42,height:42,borderRadius:12,objectFit:'contain',filter:'drop-shadow(0 2px 6px rgba(251,191,36,0.3))'}}/>
        </div>
        {items.map(key => {
          const item = menuCatalog[key];
          const active = key === activeKey;
          return (
            <div key={key} title={item.label}
              className={cn('h-11 w-11 rounded-xl flex items-center justify-center',
                active ? 'bg-yellow-400/10 text-yellow-400' : 'text-neutral-500')}>
              <Icon type={item.icon} className="h-4 w-4" />
            </div>
          );
        })}
        <div className="mt-auto pt-3">
          <div className="text-neutral-600 text-[13px] text-center">กดเปิด</div>
          <svg viewBox="0 0 24 24" fill="none" className="h-4 w-4 text-neutral-600 mx-auto mt-1" stroke="currentColor" strokeWidth="2"><path d="M9 6l6 6-6 6" strokeLinecap="round" strokeLinejoin="round"/></svg>
        </div>
      </aside>
    );
  }

  // ═══ Expanded: full sidebar ═══
  return (
    <aside className="flex w-56 shrink-0 flex-col border-r border-white/5 bg-[#0a1628]/80">
      <div className="px-4 py-3.5 flex items-center justify-between border-b border-white/[0.04]">
        <div className="flex items-center gap-2.5">
          <img src={TSMC_LOGO} alt="TSMC" style={{width:40,height:40,borderRadius:12,objectFit:'contain',filter:'drop-shadow(0 2px 8px rgba(251,191,36,0.4))'}}/>
          <div>
            <span className="text-sm font-bold tracking-tight text-white block leading-tight">TSMC</span>
            <span className="text-[13px] text-neutral-500 leading-tight">Transport Safety</span>
          </div>
        </div>
        <button onClick={onToggle} className="h-9 w-9 rounded-xl flex items-center justify-center hover:bg-white/8 active:bg-white/10 cursor-pointer transition-all" title="ซ่อนเมนู">
          <svg viewBox="0 0 24 24" fill="none" className="h-5 w-5 text-neutral-400" stroke="currentColor" strokeWidth="2"><path d="M15 18l-6-6 6-6" strokeLinecap="round" strokeLinejoin="round"/></svg>
        </button>
      </div>

      <nav className="flex-1 px-3 py-2 space-y-0.5 overflow-y-auto">
        {items.map((key) => {
          const item = menuCatalog[key];
          const active = key === activeKey;
          return (
            <button
              key={key}
              onClick={() => onChange(key)}
              className={cn(
                'w-full flex items-center gap-3 rounded-xl px-3.5 py-3 text-base text-left cursor-pointer transition-all duration-150',
                active
                  ? 'bg-yellow-400/15 text-yellow-400 shadow-[inset_3px_0_0_0_#FBBF24]'
                  : 'text-neutral-400 hover:text-white hover:bg-white/8 hover:pl-5 hover:shadow-[inset_3px_0_0_0_rgba(251,191,36,0.4)]'
              )}
              style={active ? {transform:'scale(1)'} : {}}
              onMouseEnter={e => { if(!active) e.currentTarget.style.transform='scale(1.02)'; }}
              onMouseLeave={e => { e.currentTarget.style.transform='scale(1)'; }}
              onMouseDown={e => { e.currentTarget.style.transform='scale(0.97)'; }}
              onMouseUp={e => { e.currentTarget.style.transform='scale(1.02)'; }}
            >
              <Icon type={item.icon} className={cn('transition-transform duration-150', active ? 'text-yellow-400' : 'text-neutral-500')} />
              <span className="font-medium">{item.label}</span>
              {active && <div className="ml-auto w-1.5 h-1.5 rounded-full bg-yellow-400" />}
            </button>
          );
        })}
      </nav>

      <div className="p-3.5 mx-3 mb-3 mt-auto rounded-xl bg-gradient-to-r from-yellow-400/[0.06] to-transparent border border-yellow-400/10">
        <div className="flex items-center gap-2.5">
          <div className="h-8 w-8 rounded-lg bg-yellow-400/15 flex items-center justify-center">
            <Icon type={roleMeta[role].icon} className="text-yellow-400 h-4 w-4" />
          </div>
          <div>
            <p className="text-sm text-white font-medium leading-tight">{roleMeta[role].label}</p>
            <p className="text-[13px] text-neutral-500 leading-tight">Active role</p>
          </div>
        </div>
      </div>
    </aside>
  );
}


/* ═══════════════════════════════════════════
   DATA JOURNEY PROGRESS — simplified
   ═══════════════════════════════════════════ */
function DataJourney({ role }) {
  const journey = roleJourneys[role];
  const allSteps = journey.phases.flatMap((p) => p.steps);
  const doneCount = allSteps.filter((s) => s.done).length;
  const pct = Math.round((doneCount / allSteps.length) * 100);

  return (
    <div className="rounded-2xl border border-white/[0.06] bg-gradient-to-br from-white/[0.03] to-transparent p-5">
      <div className="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4 mb-5">
        <div>
          <Badge className="mb-2">Data Journey</Badge>
          <h3 className="text-base font-semibold text-white">{journey.title}</h3>
        </div>
        <div className="text-right">
          <p className="text-2xl font-bold text-white">{pct}%</p>
          <p className="text-[13px] text-neutral-500">ภารกิจทั้งหมด</p>
          <div className="mt-2 w-40 h-1.5 rounded-full bg-white/8">
            <div className="h-1.5 rounded-full bg-yellow-400 transition-all" style={{ width: `${pct}%` }} />
          </div>
        </div>
      </div>

      <div className="space-y-3">
        {journey.phases.map((phase, pi) => {
          const phaseDone = phase.steps.filter((s) => s.done).length;
          const phasePct = Math.round((phaseDone / phase.steps.length) * 100);
          return (
            <div key={pi} className="rounded-lg border border-white/5 bg-[#0f1d32]/50 p-4">
              <div className="flex items-center justify-between mb-3">
                <p className="text-sm font-medium text-white">{phase.title}</p>
                <span className="text-[13px] text-neutral-500">{phaseDone}/{phase.steps.length}</span>
              </div>
              <div className="h-1 rounded-full bg-white/8 mb-3">
                <div className="h-1 rounded-full bg-emerald-400 transition-all" style={{ width: `${phasePct}%` }} />
              </div>
              <div className="flex flex-wrap gap-2">
                {phase.steps.map((step, si) => (
                  <span key={si} className={cn('inline-flex items-center gap-1.5 rounded-lg px-2.5 py-1 text-[13px] border', step.done ? 'bg-emerald-500/8 border-emerald-500/15 text-emerald-400' : 'bg-white/2 border-white/5 text-neutral-500')}>
                    {step.done && <Icon type="check" className="h-3 w-3" />}
                    {step.label}
                  </span>
                ))}
              </div>
            </div>
          );
        })}
      </div>
    </div>
  );
}


/* ═══════════════════════════════════════════
   TREE STRUCTURE — simplified grid
   ═══════════════════════════════════════════ */
function TreeStructure({ role }) {
  const tree = treeStructures[role];
  return (
    <div className="rounded-2xl border border-white/[0.06] bg-gradient-to-br from-white/[0.03] to-transparent p-5">
      <Badge className="mb-2">Information Architecture</Badge>
      <h3 className="text-base font-semibold text-white mb-4">Tree Structure — {roleMeta[role].label}</h3>
      <div className="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-3">
        {tree.map((branch, i) => (
          <div key={i} className="rounded-lg border border-white/5 bg-[#0f1d32]/50 p-3.5">
            <p className="text-sm font-medium text-white mb-2">{branch.title}</p>
            <div className="space-y-1">
              {branch.items.map((item, j) => (
                <p key={j} className="text-[13px] text-neutral-400 py-1 px-2 rounded bg-white/2">{item}</p>
              ))}
            </div>
          </div>
        ))}
      </div>
    </div>
  );
}


/* ═══════════════════════════════════════════
   KPI CARDS — clean & flat
   ═══════════════════════════════════════════ */
function KPIGrid({ items }) {
  const sparks = [[3,5,4,7,6,8,7],[5,3,6,4,7,5,8],[2,4,3,5,7,6,9],[4,6,5,3,4,7,6]];
  return (
    <div className="grid grid-cols-2 xl:grid-cols-4 gap-3">
      {items.map((item, idx) => {
        const sp = sparks[idx % 4];
        const max = Math.max(...sp);
        const pts = sp.map((v,i) => `${i*(60/(sp.length-1))},${28-v/max*24}`).join(' ');
        return (
        <div key={item.label} className="rounded-2xl p-4 cursor-pointer transition-all duration-200 group"
          style={{border:'1px solid rgba(255,255,255,0.06)',background:'linear-gradient(135deg,rgba(255,255,255,0.03),transparent)'}}
          onMouseEnter={e => {e.currentTarget.style.borderColor='rgba(251,191,36,0.2)';e.currentTarget.style.transform='translateY(-2px)';}}
          onMouseLeave={e => {e.currentTarget.style.borderColor='rgba(255,255,255,0.06)';e.currentTarget.style.transform='translateY(0)';}}>
          <div className="flex items-center justify-between mb-2">
            <p className="text-sm text-neutral-400 font-medium">{item.label}</p>
            <div className="h-7 w-7 rounded-lg flex items-center justify-center" style={{background:'rgba(255,255,255,0.04)'}}>
              <Icon type={item.icon} className="text-neutral-500 h-3.5 w-3.5" />
            </div>
          </div>
          <div className="flex items-end justify-between">
            <div>
              <p className="text-3xl font-bold text-white tracking-tight">{item.value}</p>
              <p className="text-[13px] text-neutral-500 mt-0.5">{item.unit}</p>
            </div>
            <svg viewBox="0 0 60 28" className="w-16 h-7 opacity-40 group-hover:opacity-70 transition-opacity">
              <polyline points={pts} fill="none" stroke="#FBBF24" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round"/>
            </svg>
          </div>
        </div>
        );
      })}
    </div>
  );
}


/* ═══════════════════════════════════════════
   QUICK ACTIONS
   ═══════════════════════════════════════════ */
function QuickActions({ items }) {
  const qIcons = ['arrowRight','clipboard','send','chart'];
  return (
    <div className="grid grid-cols-2 xl:grid-cols-4 gap-2">
      {items.map((item, i) => (
        <button key={item} className="rounded-2xl px-4 py-3.5 text-sm text-neutral-300 font-medium text-left cursor-pointer transition-all duration-200 flex items-center gap-2.5 group"
          style={{border:'1px solid rgba(255,255,255,0.06)',background:'rgba(255,255,255,0.02)'}}
          onMouseEnter={e => {e.currentTarget.style.borderColor='rgba(251,191,36,0.2)';e.currentTarget.style.background='rgba(251,191,36,0.04)';e.currentTarget.style.color='white';}}
          onMouseLeave={e => {e.currentTarget.style.borderColor='rgba(255,255,255,0.06)';e.currentTarget.style.background='rgba(255,255,255,0.02)';e.currentTarget.style.color='';}}>
          <div className="w-7 h-7 rounded-lg flex items-center justify-center shrink-0" style={{background:'rgba(255,255,255,0.04)'}}>
            <Icon type={qIcons[i%4]} className="h-3 w-3 text-neutral-600 group-hover:text-yellow-400 transition-colors" />
          </div>
          <span className="flex-1">{item}</span>
        </button>
      ))}
    </div>
  );
}


/* ═══════════════════════════════════════════
   INFO SECTION
   ═══════════════════════════════════════════ */
function InfoSection({ title, items, icon }) {
  return (
    <div className="rounded-2xl border border-white/[0.06] bg-gradient-to-br from-white/[0.03] to-transparent p-4">
      <div className="flex items-center gap-2.5 mb-3">
        <div className="h-7 w-7 rounded-lg bg-yellow-400/10 flex items-center justify-center">
          <Icon type={icon} className="text-yellow-400 h-3.5 w-3.5" />
        </div>
        <h4 className="text-sm font-medium text-white">{title}</h4>
      </div>
      <div className="space-y-1.5">
        {items.map((item, i) => (
          <p key={i} className="text-[13px] text-neutral-400 leading-relaxed py-1.5 px-3 rounded-lg bg-[#0f1d32]/40">{item}</p>
        ))}
      </div>
    </div>
  );
}


/* ═══════════════════════════════════════════
   PROFILE BAR — premium redesign
   ═══════════════════════════════════════════ */
function ProfileDropdown({ role, show, onToggle, onLogout, sessionMin, onProfilePage }) {
  const [activeCompany, setActiveCompany] = useState(0);
  const profile = roleProfiles[role];
  const sc = sessionMin > 10 ? '#34D399' : sessionMin > 5 ? '#FBBF24' : '#F87171';
  const pct = Math.round((sessionMin / 30) * 100);

  return (
    <div className="relative">
      {/* ═══ Trigger — avatar + status ring ═══ */}
      <button onClick={onToggle}
        className="flex items-center gap-2 rounded-2xl pl-1 pr-3 py-1 cursor-pointer transition-all duration-200 hover:bg-white/[0.06]"
        style={{border:'1px solid rgba(255,255,255,0.06)'}}>
        <div className="relative">
          <div className="h-9 w-9 rounded-xl bg-gradient-to-br from-yellow-400 to-yellow-500 flex items-center justify-center text-sm font-bold text-neutral-900">{profile.name[0]}</div>
          {/* Animated session ring */}
          <svg className="absolute -inset-0.5" viewBox="0 0 40 40" style={{width:40,height:40,transform:'rotate(-90deg)'}}>
            <circle cx="20" cy="20" r="18" fill="none" stroke="rgba(255,255,255,0.06)" strokeWidth="2"/>
            <circle cx="20" cy="20" r="18" fill="none" stroke={sc} strokeWidth="2" strokeLinecap="round"
              strokeDasharray={`${pct * 1.13} 200`} style={{transition:'stroke-dasharray 1s ease'}}/>
          </svg>
        </div>
        <div className="text-left hidden sm:block">
          <p className="text-[13px] font-medium text-white leading-tight">{profile.name}</p>
          <p className="text-[13px] text-neutral-500 leading-tight">{sessionMin}m</p>
        </div>
      </button>

      {/* ═══ Dropdown panel ═══ */}
      {show && (
        <div className="absolute right-0 top-full mt-2 w-80 rounded-2xl overflow-hidden z-50"
          style={{background:'#0c1524',border:'1px solid rgba(255,255,255,0.08)',boxShadow:'0 20px 60px rgba(0,0,0,0.5)'}}>

          {/* ── Gold banner header ── */}
          <div style={{background:'linear-gradient(135deg,#FBBF24,#F59E0B,#D97706)',padding:'20px 16px 40px',position:'relative',overflow:'hidden'}}>
            <div style={{position:'absolute',top:-30,right:-30,width:120,height:120,borderRadius:'50%',background:'rgba(255,255,255,0.12)'}}/>
            <div style={{position:'absolute',bottom:-15,left:'40%',width:80,height:80,borderRadius:'50%',background:'rgba(255,255,255,0.08)'}}/>
            <div className="flex items-center gap-3 relative" style={{zIndex:2}}>
              <div style={{width:52,height:52,borderRadius:16,background:'rgba(0,0,0,0.15)',display:'flex',alignItems:'center',justifyContent:'center',fontSize:22,fontWeight:800,color:'white',border:'2px solid rgba(255,255,255,0.3)',flexShrink:0}}>
                {profile.name[0]}
              </div>
              <div style={{flex:1}}>
                <p style={{fontSize:16,fontWeight:700,color:'#1a1a1a',margin:0}}>{profile.name}</p>
                <p style={{fontSize:13,fontWeight:600,color:'rgba(0,0,0,0.5)',margin:0}}>{profile.role}</p>
              </div>
              <div style={{background:'rgba(0,0,0,0.1)',borderRadius:10,padding:'4px 10px',fontSize:13,fontWeight:700,color:'rgba(0,0,0,0.6)'}}>Online</div>
            </div>
          </div>

          {/* ── Stats cards (pulled up over banner) ── */}
          <div className="flex gap-2 px-3" style={{marginTop:-24,position:'relative',zIndex:3}}>
            <div className="flex-1 rounded-xl p-2.5 text-center" style={{background:'#0f1d32',border:'1px solid rgba(255,255,255,0.06)'}}>
              <p style={{fontSize:13,color:'rgba(255,255,255,0.4)',margin:0}}>แผนก</p>
              <p className="text-[13px] text-white font-medium truncate mt-0.5">{profile.dept}</p>
            </div>
            <div className="flex-1 rounded-xl p-2.5 text-center" style={{background:'#0f1d32',border:'1px solid rgba(255,255,255,0.06)'}}>
              <p style={{fontSize:13,color:'rgba(255,255,255,0.4)',margin:0}}>เซสชัน</p>
              <p className="text-[13px] font-bold mt-0.5" style={{color:sc}}>{sessionMin} นาที</p>
            </div>
            <div className="flex-1 rounded-xl p-2.5 text-center" style={{background:'#0f1d32',border:'1px solid rgba(255,255,255,0.06)'}}>
              <p style={{fontSize:13,color:'rgba(255,255,255,0.4)',margin:0}}>คะแนน</p>
              <p className="text-[13px] text-yellow-400 font-bold mt-0.5">680</p>
            </div>
          </div>

          {/* ── Contact row ── */}
          <div className="flex items-center gap-4 px-4 py-2.5 mt-2" style={{borderBottom:'1px solid rgba(255,255,255,0.04)'}}>
            <div className="flex items-center gap-1.5 text-[13px] text-neutral-500 flex-1 truncate">
              <Icon type="mail" className="h-3 w-3 text-neutral-600 shrink-0"/><span className="truncate">{profile.email}</span>
            </div>
            <div className="flex items-center gap-1.5 text-[13px] text-neutral-500 shrink-0">
              <Icon type="phone" className="h-3 w-3 text-neutral-600"/><span>{profile.phone}</span>
            </div>
          </div>

          {/* ── Menu items ── */}
          <div className="p-2">
            {[
              {icon:'users', label:'จัดการโปรไฟล์', badge:null, color:null},
              {icon:'lock', label:'เปลี่ยนรหัสผ่าน', badge:null, color:null},
              {icon:'bell', label:'ตั้งค่าแจ้งเตือน', badge:'3', color:'#F59E0B'},
              {icon:'settings', label:'ตั้งค่าระบบ', badge:'ใหม่', color:'#34D399'},
            ].map(item => (
              <button key={item.label} onClick={() => { if(onProfilePage) onProfilePage(); }}
                className="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-sm transition-all duration-150 cursor-pointer group"
                style={{color:'rgba(255,255,255,0.6)'}}
                onMouseEnter={e => {e.currentTarget.style.background='rgba(255,255,255,0.04)';e.currentTarget.style.transform='translateX(3px)';e.currentTarget.style.color='white';}}
                onMouseLeave={e => {e.currentTarget.style.background='transparent';e.currentTarget.style.transform='translateX(0)';e.currentTarget.style.color='rgba(255,255,255,0.6)';}}>
                <div className="w-7 h-7 rounded-lg flex items-center justify-center shrink-0" style={{background:'rgba(255,255,255,0.04)'}}>
                  <Icon type={item.icon} className="h-3.5 w-3.5"/>
                </div>
                <span className="flex-1 text-left font-medium">{item.label}</span>
                {item.badge && (
                  <span className="text-[13px] font-bold px-1.5 py-0.5 rounded-md" style={{background:item.color+'20',color:item.color}}>{item.badge}</span>
                )}
                <svg viewBox="0 0 12 12" className="h-3 w-3 opacity-30"><path d="M4.5 3l3 3-3 3" fill="none" stroke="currentColor" strokeWidth="1.5" strokeLinecap="round"/></svg>
              </button>
            ))}
          </div>

          {/* ── Company Switcher — TSM only (1 TSM ดูแลได้สูงสุด 5 บริษัท) ── */}
          {role === 'tsm' && (() => {
            const companies = [
              {name:'ขนส่งปลอดภัย จำกัด',vehicles:8,drivers:6,routes:3,active:true},
              {name:'โลจิสติกส์อีสาน จำกัด',vehicles:12,drivers:10,routes:5,active:false},
              {name:'ทรานสปอร์ต กรุงเทพ',vehicles:5,drivers:4,routes:2,active:false},
              {name:'ขนส่งด่วน นครราชสีมา',vehicles:15,drivers:12,routes:4,active:false},
              {name:'เอ็กซ์เพรส อุดรธานี',vehicles:3,drivers:3,routes:1,active:false},
            ];
            return (
            <div className="px-2 pb-2">
              <div className="rounded-xl overflow-hidden" style={{border:'1px solid rgba(251,191,36,0.12)'}}>
                <div className="px-3 py-2 flex items-center gap-2" style={{background:'linear-gradient(135deg,rgba(251,191,36,0.08),transparent)'}}>
                  <Icon type="building" className="h-3.5 w-3.5 text-yellow-400"/>
                  <p className="text-[13px] font-bold text-yellow-400">สลับบริษัท</p>
                  <span className="text-[13px] text-neutral-600 ml-auto">{companies.length}/5</span>
                </div>
                <div className="p-1.5">
                  {companies.map((co, i) => (
                    <button key={i} onClick={() => setActiveCompany(i)}
                      className="w-full flex items-center gap-2 px-2.5 py-2 rounded-lg cursor-pointer transition-all duration-150"
                      style={{background: activeCompany === i ? 'rgba(251,191,36,0.08)' : 'transparent',
                        borderLeft: activeCompany === i ? '3px solid #FBBF24' : '3px solid transparent'}}
                      onMouseEnter={e=>{if(activeCompany!==i) e.currentTarget.style.background='rgba(255,255,255,0.03)';}}
                      onMouseLeave={e=>{if(activeCompany!==i) e.currentTarget.style.background='transparent';}}>
                      <div className="w-7 h-7 rounded-lg flex items-center justify-center text-[13px] font-bold shrink-0"
                        style={{background: activeCompany === i ? 'linear-gradient(135deg,#FBBF24,#F59E0B)' : 'rgba(255,255,255,0.04)',
                          color: activeCompany === i ? '#1a1a1a' : 'rgba(255,255,255,0.3)'}}>
                        {co.name[0]}
                      </div>
                      <div className="flex-1 min-w-0 text-left">
                        <p className="text-[13px] font-medium truncate" style={{color: activeCompany === i ? '#FBBF24' : 'rgba(255,255,255,0.5)'}}>{co.name}</p>
                        <p className="text-[13px] text-neutral-600">{co.vehicles} คัน • {co.drivers} คน</p>
                      </div>
                      {activeCompany === i && <div className="w-1.5 h-1.5 rounded-full bg-yellow-400 shrink-0"/>}
                    </button>
                  ))}
                </div>
              </div>
            </div>
            );
          })()}

          {/* ── Theme toggle row ── */}
          <div className="px-4 py-2" style={{borderTop:'1px solid rgba(255,255,255,0.04)'}}>
            <div className="flex items-center justify-between">
              <span className="text-[13px] text-neutral-500">โหมดมืด</span>
              <div className="w-9 h-5 rounded-full bg-yellow-400 relative cursor-pointer">
                <div className="w-4 h-4 rounded-full bg-white absolute top-0.5 left-[18px]" style={{transition:'left 0.2s'}}/>
              </div>
            </div>
          </div>

          {/* ── Logout ── */}
          <div className="p-2 pt-0">
            <button onClick={() => { if(onLogout) onLogout(); }}
              className="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-sm cursor-pointer transition-all duration-150"
              style={{color:'#F87171'}}
              onMouseEnter={e => {e.currentTarget.style.background='rgba(248,113,113,0.08)';e.currentTarget.style.transform='translateX(3px)';}}
              onMouseLeave={e => {e.currentTarget.style.background='transparent';e.currentTarget.style.transform='translateX(0)';}}>
              <div className="w-7 h-7 rounded-lg flex items-center justify-center shrink-0" style={{background:'rgba(248,113,113,0.08)'}}>
                <Icon type="logout" className="h-3.5 w-3.5"/>
              </div>
              <span className="flex-1 text-left font-medium">ออกจากระบบ</span>
            </button>
          </div>
        </div>
      )}
    </div>
  );
}


/* ═══════════════════════════════════════════
   FORMS DATA — 18 แบบฟอร์ม 5 Tier ตามกฎหมาย TSM
   ═══════════════════════════════════════════ */
const TIER_NAMES = { 0:'บริหาร', 1:'ก่อนปฏิบัติงาน', 2:'ระหว่างปฏิบัติงาน', 3:'หลังปฏิบัติงาน', 4:'ตามรอบ (สัปดาห์/เดือน)', 5:'เหตุการณ์พิเศษ' };

const FORMS = [
  { id:'F01', tier:1, name:'ตรวจความพร้อมรถ', icon:'car', fields:10, points:12, gps:true },
  { id:'F02', tier:1, name:'ROLLCALL ก่อนปฏิบัติงาน', icon:'clipboard', fields:8, points:10, gps:true },
  { id:'F03', tier:1, name:'ตรวจเส้นทาง', icon:'route', fields:6, points:8, gps:true },
  { id:'F04', tier:1, name:'ตรวจสินค้า/ผู้โดยสาร', icon:'truck', fields:8, points:10, gps:true },
  { id:'F05', tier:2, name:'GPS Tracking อัตโนมัติ', icon:'route', fields:5, points:6, gps:true },
  { id:'F06', tier:2, name:'ROLLCALL ระหว่างปฏิบัติงาน', icon:'clipboard', fields:6, points:8, gps:true },
  { id:'F08', tier:3, name:'ROLLCALL หลังปฏิบัติงาน', icon:'clipboard', fields:6, points:8, gps:true },
  { id:'F09', tier:3, name:'บันทึกเหตุการณ์ระหว่างเดินทาง', icon:'incident', fields:8, points:10, gps:true },
  { id:'F10', tier:4, name:'แผนบำรุงรักษารถ', icon:'car', fields:10, points:12, gps:false },
  { id:'F11', tier:4, name:'Log Book บันทึกการเดินรถ', icon:'file', fields:12, points:15, gps:false },
  { id:'F12', tier:4, name:'บันทึกบำรุงรักษารถ', icon:'car', fields:8, points:10, gps:false },
  { id:'F13', tier:4, name:'แผนฝึกอบรมผู้ขับรถ', icon:'training', fields:8, points:10, gps:false },
  { id:'F14', tier:4, name:'ตรวจสุขภาพผู้ขับรถ', icon:'users', fields:10, points:12, gps:false },
  { id:'F15', tier:5, name:'รายงานอุบัติเหตุ/เหตุฉุกเฉิน', icon:'incident', fields:15, points:20, gps:true },
  { id:'F16', tier:0, name:'แผนปฏิบัติงาน TSM ประจำปี', icon:'clipboard', fields:10, points:15, gps:false },
  { id:'F17', tier:0, name:'รายงานผลการปฏิบัติงาน TSM', icon:'send', fields:12, points:15, gps:false },
  { id:'F18', tier:0, name:'แจ้งรายชื่อผู้ประกอบการที่รับผิดชอบ', icon:'building', fields:8, points:10, gps:false },
];

const FORM_QS = {
  F01: [{q:'ทะเบียนรถ',type:'search',searchType:'vehicle',opts:['กน-1658 กรุงเทพ (HINO 500 6ล้อ)','1กฐ-6852 ขอนแก่น (ISUZU FTR 10ล้อ)','บท-3091 นครราชสีมา (HINO 300 6ล้อ)','80-4517 ชลบุรี (VOLVO FH 18ล้อ)','ผก-2244 ขอนแก่น (HINO 500 6ล้อ)','2กจ-8103 กรุงเทพ (ISUZU GXZ 10ล้อ)','บบ-7765 อุดรธานี (HINO 300 6ล้อ)','81-9930 ขอนแก่น (VOLVO FM 18ล้อ)']},{q:'สภาพยาง',type:'select',opts:['ดี','พอใช้','ต้องเปลี่ยน']},{q:'ระบบเบรก',type:'select',opts:['ปกติ','ผิดปกติ']},{q:'ไฟสัญญาณ',type:'select',opts:['ปกติ','ผิดปกติ']},{q:'ระดับน้ำมัน',type:'select',opts:['เต็ม','ครึ่ง','ต่ำ']},{q:'อุปกรณ์ความปลอดภัย (ถังดับเพลิง/สามเหลี่ยม/กรวย)',type:'select',opts:['ครบ','ไม่ครบ — ระบุ']},{q:'ถ่ายรูปรถ',type:'photo'},{q:'หมายเหตุ (ข้ามได้)',type:'note',presets:['ไม่มี','รถสกปรก','ต้องซ่อม','อื่นๆ']}],
  F02: [{q:'ชื่อผู้ขับ',type:'search',searchType:'driver',opts:['ประเสริฐ รถมั่นคง (กน-1658)','สุรชัย ขับดี (1กฐ-6852)','อนันต์ ปลอดภัย (บท-3091)','วิชัย ส่งด่วน (ผก-2244)','สมศักดิ์ ถนนดี (2กจ-8103)','ธนา เดินทาง (81-9930)']},{q:'กะ/ตารางปฏิบัติงาน',type:'select',opts:['กะเช้า (06:00-18:00)','กะดึก (18:00-06:00)','ปกติ (08:00-17:00)','OT/ล่วงเวลา']},{q:'แอลกอฮอล์ (mg%)',type:'select',opts:['0 mg%','ต่ำกว่า 20 mg%','เกิน 20 mg%','ไม่ได้ตรวจ']},{q:'สภาพร่างกาย',type:'select',opts:['พร้อมปฏิบัติงาน','ไม่พร้อม — ป่วย','ไม่พร้อม — อ่อนล้า']},{q:'สารเสพติด',type:'select',opts:['ผ่าน','ไม่ผ่าน','ไม่ได้ตรวจ']},{q:'หมายเหตุ (ข้ามได้)',type:'note',presets:['ไม่มี','รถสกปรก','ต้องซ่อม','อื่นๆ']}],
  F03: [{q:'ต้นทาง',type:'auto'},{q:'ปลายทาง',type:'auto'},{q:'ระยะทาง (km)',type:'select',opts:['< 100 km','100-300 km','300-500 km','> 500 km']},{q:'สภาพเส้นทาง',type:'select',opts:['ปกติ','ก่อสร้าง','น้ำท่วม','อื่นๆ']},{q:'จุดพักระหว่างทาง',type:'select',opts:['มี','ไม่มี']}],
  F04: [{q:'ประเภท',type:'select',opts:['สินค้าทั่วไป','สินค้าอันตราย','ผู้โดยสาร','สินค้าแช่เย็น']},{q:'น้ำหนักบรรทุก',type:'select',opts:['< 2,000 kg','2,000-5,000 kg','5,000-8,000 kg','> 8,000 kg']},{q:'ปฏิบัติตามคู่มือการบรรทุก',type:'select',opts:['ปฏิบัติครบ','ปฏิบัติบางส่วน','ไม่ได้ปฏิบัติ']},{q:'ตรวจสภาพ',type:'select',opts:['เรียบร้อย','มีปัญหา']},{q:'อุณหภูมิห้องเย็น (°C)',type:'select',opts:['ไม่ใช้','≤ 0°C','0-4°C','> 4°C']}],
  F05: [{q:'ตำแหน่งปัจจุบัน (GPS)',type:'auto'},{q:'ระยะทางสะสม (km)',type:'auto'},{q:'ความเร็วเฉลี่ย (km/h)',type:'auto'},{q:'สถานะ (ตรวจจับจาก GPS)',type:'auto'},{q:'จุดหยุดพักที่ผ่านมา',type:'auto'}],
  F06: [{q:'ชื่อผู้ขับ',type:'search',searchType:'driver',opts:['ประเสริฐ รถมั่นคง (กน-1658)','สุรชัย ขับดี (1กฐ-6852)','อนันต์ ปลอดภัย (บท-3091)','วิชัย ส่งด่วน (ผก-2244)','สมศักดิ์ ถนนดี (2กจ-8103)','ธนา เดินทาง (81-9930)']},{q:'แอลกอฮอล์ (mg%)',type:'select',opts:['0 mg%','ต่ำกว่า 20 mg%','เกิน 20 mg%']},{q:'ความเหนื่อยล้า',type:'select',opts:['ปกติ','เริ่มเหนื่อย','เหนื่อยมาก']},{q:'ต้องการหยุดพัก',type:'select',opts:['ไม่','ใช่']}],
  F08: [{q:'ชื่อผู้ขับ',type:'search',searchType:'driver',opts:['ประเสริฐ รถมั่นคง (กน-1658)','สุรชัย ขับดี (1กฐ-6852)','อนันต์ ปลอดภัย (บท-3091)','วิชัย ส่งด่วน (ผก-2244)','สมศักดิ์ ถนนดี (2กจ-8103)','ธนา เดินทาง (81-9930)']},{q:'แอลกอฮอล์ (mg%)',type:'select',opts:['0 mg%','ต่ำกว่า 20 mg%','เกิน 20 mg%']},{q:'ชั่วโมงขับรถวันนี้',type:'select',opts:['< 4 hh:mm','4-8 hh:mm','8-10 hh:mm','> 10 hh:mm']},{q:'ระยะทางวันนี้ (km)',type:'auto'},{q:'เหตุผิดปกติ',type:'select',opts:['ไม่มี','มี']}],
  F09: [{q:'ประเภทเหตุ',type:'select',opts:['อุบัติเหตุ','รถเสีย','สินค้าเสียหาย','จราจร','อื่นๆ']},{q:'ความรุนแรง',type:'select',opts:['เล็กน้อย','ปานกลาง','รุนแรง']},{q:'สถานที่',type:'auto'},{q:'ถ่ายรูป',type:'photo'},{q:'รายละเอียด (ข้ามได้)',type:'note',presets:['ไม่มี','ระบุในรายงาน','ดูภาพถ่ายประกอบ','อื่นๆ']}],
  F10: [{q:'ทะเบียนรถ',type:'search',searchType:'vehicle',opts:['กน-1658 กรุงเทพ (HINO 500 6ล้อ)','1กฐ-6852 ขอนแก่น (ISUZU FTR 10ล้อ)','บท-3091 นครราชสีมา (HINO 300 6ล้อ)','80-4517 ชลบุรี (VOLVO FH 18ล้อ)','ผก-2244 ขอนแก่น (HINO 500 6ล้อ)','2กจ-8103 กรุงเทพ (ISUZU GXZ 10ล้อ)','บบ-7765 อุดรธานี (HINO 300 6ล้อ)','81-9930 ขอนแก่น (VOLVO FM 18ล้อ)']},{q:'ประเภทซ่อม',type:'select',opts:['ตามระยะ','ตามเวลา','ซ่อมฉุกเฉิน']},{q:'รายการ',type:'select',opts:['เปลี่ยนถ่ายน้ำมัน','เปลี่ยนยาง','เบรก','ช่วงล่าง','ไฟฟ้า','อื่นๆ']},{q:'กำหนดวัน',type:'select',opts:['สัปดาห์นี้','สัปดาห์หน้า','เดือนหน้า']}],
  F11: [{q:'ทะเบียนรถ',type:'search',searchType:'vehicle',opts:['กน-1658 กรุงเทพ (HINO 500 6ล้อ)','1กฐ-6852 ขอนแก่น (ISUZU FTR 10ล้อ)','บท-3091 นครราชสีมา (HINO 300 6ล้อ)','80-4517 ชลบุรี (VOLVO FH 18ล้อ)','ผก-2244 ขอนแก่น (HINO 500 6ล้อ)','2กจ-8103 กรุงเทพ (ISUZU GXZ 10ล้อ)','บบ-7765 อุดรธานี (HINO 300 6ล้อ)','81-9930 ขอนแก่น (VOLVO FM 18ล้อ)']},{q:'ต้นทาง',type:'auto'},{q:'ปลายทาง',type:'auto'},{q:'ระยะทาง (km)',type:'auto'},{q:'เวลาออก',type:'auto'},{q:'เวลาถึง',type:'auto'},{q:'ความเร็วเฉลี่ย (km/h)',type:'auto'},{q:'ความเร็วสูงสุด (km/h)',type:'auto'},{q:'จุดหยุดพัก (GPS ตรวจจับ)',type:'auto'},{q:'จำนวนครั้งหยุดพัก',type:'auto'},{q:'ระยะเวลาขับต่อเนื่อง (hh:mm)',type:'auto'},{q:'เหตุผิดปกติระหว่างทาง',type:'select',opts:['ไม่มี','มี — ดูฟอร์ม F09']}],
  F12: [{q:'ทะเบียนรถ',type:'search',searchType:'vehicle',opts:['กน-1658 กรุงเทพ (HINO 500 6ล้อ)','1กฐ-6852 ขอนแก่น (ISUZU FTR 10ล้อ)','บท-3091 นครราชสีมา (HINO 300 6ล้อ)','80-4517 ชลบุรี (VOLVO FH 18ล้อ)','ผก-2244 ขอนแก่น (HINO 500 6ล้อ)','2กจ-8103 กรุงเทพ (ISUZU GXZ 10ล้อ)','บบ-7765 อุดรธานี (HINO 300 6ล้อ)','81-9930 ขอนแก่น (VOLVO FM 18ล้อ)']},{q:'รายการที่ซ่อม',type:'select',opts:['เปลี่ยนถ่ายน้ำมัน','เปลี่ยนยาง','เบรก','ช่วงล่าง','ไฟฟ้า','อื่นๆ']},{q:'ผลการซ่อม',type:'select',opts:['เรียบร้อย','ต้องซ่อมต่อ']},{q:'ถ่ายรูป',type:'photo'}],
  F13: [{q:'ชื่อผู้เข้าอบรม',type:'search',searchType:'driver',opts:['ประเสริฐ รถมั่นคง','สุรชัย ขับดี','อนันต์ ปลอดภัย','วิชัย ส่งด่วน','สมศักดิ์ ถนนดี','ธนา เดินทาง']},{q:'หลักสูตร',type:'select',opts:['ขับรถปลอดภัย','การบรรทุก','เหตุฉุกเฉิน','กฎจราจร','อื่นๆ']},{q:'จำนวนชั่วโมง',type:'select',opts:['3 ชม.','6 ชม.','18 ชม.']},{q:'ผลประเมิน',type:'select',opts:['ผ่าน','ไม่ผ่าน']}],
  F14: [{q:'ชื่อผู้ตรวจ',type:'search',searchType:'driver',opts:['ประเสริฐ รถมั่นคง','สุรชัย ขับดี','อนันต์ ปลอดภัย','วิชัย ส่งด่วน','สมศักดิ์ ถนนดี','ธนา เดินทาง']},{q:'ความดันโลหิต',type:'select',opts:['ปกติ','สูง','ต่ำ']},{q:'สายตา',type:'select',opts:['ปกติ','ผิดปกติ']},{q:'โรคประจำตัว',type:'select',opts:['ไม่มี','เบาหวาน','ความดัน','หัวใจ','อื่นๆ']},{q:'ผลสรุป',type:'select',opts:['ผ่าน','ไม่ผ่าน']}],
  F15: [{q:'ประเภทเหตุ',type:'select',opts:['อุบัติเหตุท้องถนน','ไฟไหม้','สารเคมีรั่ว','เหตุธรรมชาติ','อื่นๆ']},{q:'ความรุนแรง',type:'select',opts:['เล็กน้อย','ปานกลาง','รุนแรง','วิกฤต']},{q:'ผู้บาดเจ็บ',type:'select',opts:['ไม่มี','1-2 คน','มากกว่า 2 คน']},{q:'สถานที่',type:'auto'},{q:'ถ่ายรูป',type:'photo'},{q:'รายละเอียด (ข้ามได้)',type:'note',presets:['ไม่มี','ระบุในรายงาน','ดูภาพถ่ายประกอบ','อื่นๆ']}],
  F16: [{q:'ปีงบประมาณ',type:'select',opts:['2569','2570']},{q:'เป้าหมายหลัก',type:'select',opts:['ลดอุบัติเหตุ','เพิ่ม compliance','ปรับปรุงระบบ','ฝึกอบรม']},{q:'งบประมาณ',type:'select',opts:['< 100,000','100,000-500,000','> 500,000']},{q:'รายละเอียด (ข้ามได้)',type:'note',presets:['ไม่มี','ระบุในรายงาน','ดูภาพถ่ายประกอบ','อื่นๆ']}],
  F17: [{q:'ไตรมาส',type:'select',opts:['Q1','Q2','Q3','Q4']},{q:'ด้านรถ (คะแนน)',type:'select',opts:['90-100','80-89','70-79','< 70']},{q:'ด้านผู้ขับ',type:'select',opts:['90-100','80-89','70-79','< 70']},{q:'ด้านเดินรถ',type:'select',opts:['90-100','80-89','70-79','< 70']},{q:'ด้านบรรทุก',type:'select',opts:['90-100','80-89','70-79','< 70']},{q:'ด้านวิเคราะห์',type:'select',opts:['90-100','80-89','70-79','< 70']}],
  F18: [{q:'ชื่อผู้ประกอบการ',type:'auto'},{q:'เลขทะเบียน',type:'auto'},{q:'จำนวนรถ',type:'select',opts:['1-5 คัน','6-10 คัน','11-20 คัน','> 20 คัน']},{q:'ประเภทขนส่ง',type:'select',opts:['สินค้าทั่วไป','สินค้าอันตราย','ผู้โดยสาร','อื่นๆ']}],
};

/* ═══════════════════════════════════════════
   FIREWORKS — animation พลุไฟ
   ═══════════════════════════════════════════ */
function Fireworks() {
  const [particles, setParticles] = useState([]);
  React.useEffect(() => {
    const colors = ['#FBBF24','#F59E0B','#34D399','#60A5FA','#F472B6','#A78BFA','#FB923C','#22D3EE'];
    const ps = [];
    [0.25, 0.5, 0.75].forEach(cx => {
      for (let i = 0; i < 12; i++) {
        const angle = (Math.PI * 2 * i) / 12;
        const speed = 2 + Math.random() * 3;
        ps.push({ x: cx * 100, y: 40 + Math.random() * 20, vx: Math.cos(angle) * speed, vy: Math.sin(angle) * speed, color: colors[Math.floor(Math.random() * colors.length)], size: 2 + Math.random() * 3, life: 1 });
      }
    });
    setParticles(ps);
    const id = setInterval(() => {
      setParticles(prev => {
        const next = prev.map(p => ({ ...p, x: p.x + p.vx * 0.3, y: p.y + p.vy * 0.3 + 0.2, life: p.life - 0.02 })).filter(p => p.life > 0);
        if (next.length === 0) clearInterval(id);
        return next;
      });
    }, 30);
    return () => clearInterval(id);
  }, []);
  return (
    <div style={{ position: 'fixed', inset: 0, pointerEvents: 'none', zIndex: 9999 }}>
      {particles.map((p, i) => (
        <div key={i} style={{ position: 'absolute', left: `${p.x}%`, top: `${p.y}%`, width: p.size, height: p.size, borderRadius: '50%', background: p.color, opacity: p.life, transform: `scale(${p.life})` }} />
      ))}
    </div>
  );
}

/* ═══════════════════════════════════════════
   FORM LIST VIEW — ทำฟอร์มทีละข้อ + คะแนน + พลุ
   ═══════════════════════════════════════════ */
/* ═══════════════════════════════════════════
   GPS MAP — แผนที่ปักหมุดตำแหน่งรถ
   ═══════════════════════════════════════════ */
function GPSMap({ mode }) {
  const [tick, setTick] = useState(0);
  const [sel, setSel] = useState(null);
  React.useEffect(() => { const t = setInterval(() => setTick(p=>p+1), 2000); return ()=>clearInterval(t); }, []);
  const V = [{id:1,n:'ประเสริฐ',r:'กน-1658',x:52,y:48,s:78,st:'เดินทาง',rt:'ขอนแก่น→กทม.',c:'#60A5FA',km:'210/450',tx:50,ty:82},{id:2,n:'สุรชัย',r:'1กฐ-6852',x:48,y:52,s:0,st:'ถึงแล้ว',rt:'ขอนแก่น→โคราช',c:'#34D399',km:'185/185',tx:48,ty:52},{id:3,n:'อนันต์',r:'บท-3091',x:50,y:46,s:72,st:'เดินทาง',rt:'โคราช→ขอนแก่น',c:'#60A5FA',km:'95/260',tx:55,ty:28},{id:4,n:'วิชัย',r:'ผก-2244',x:56,y:22,s:0,st:'จอดพัก',rt:'ขอนแก่น→อุดร',c:'#FBBF24',km:'80/120',tx:55,ty:18},{id:5,n:'สมศักดิ์',r:'2กจ-8103',x:45,y:58,s:65,st:'เดินทาง',rt:'ขอนแก่น→ชลบุรี',c:'#60A5FA',km:'150/440',tx:42,ty:78}];
  const sv = mode==='single'?V.slice(0,1):V;
  return (
    <div className="rounded-2xl overflow-hidden" style={{border:'1px solid rgba(96,165,250,0.15)',boxShadow:'0 4px 20px rgba(0,0,0,0.3)'}}>
      <div className="px-4 py-2.5 flex items-center gap-2" style={{background:'linear-gradient(135deg,#FBBF24,#F59E0B)'}}>
        <Icon type="route" className="h-4 w-4" style={{color:'#1a1a1a'}}/>
        <p style={{fontSize:14,fontWeight:800,color:'#1a1a1a',margin:0}}>{mode==='single'?'ตำแหน่งรถของฉัน':'GPS Tracking — แผนที่รถทั้งหมด'}</p>
        <div className="flex items-center gap-1 ml-auto"><div className="w-1.5 h-1.5 rounded-full" style={{background:'#34D399',animation:'bk 2s infinite'}}/><span style={{fontSize:13,color:'rgba(0,0,0,0.5)'}}>LIVE</span></div>
      </div>
      <div style={{position:'relative',background:'linear-gradient(180deg,#0f1f35,#0a1628)'}}>
        <style>{`@keyframes bk{0%,100%{opacity:1}50%{opacity:.3}}`}</style>
        <svg viewBox="0 0 100 100" style={{width:'100%',display:'block'}}>
          {[...Array(11)].map((_,i)=><line key={'g'+i} x1={i*10} y1="0" x2={i*10} y2="100" stroke="rgba(96,165,250,0.04)" strokeWidth=".15"/>)}
          {[...Array(11)].map((_,i)=><line key={'h'+i} x1="0" y1={i*10} x2="100" y2={i*10} stroke="rgba(96,165,250,0.04)" strokeWidth=".15"/>)}
          <path d="M35,10L65,8L72,15L68,25L62,22L58,15L55,18L58,28L55,35L60,42L55,50L50,55L45,62L48,70L52,80L55,88L50,95L42,90L38,82L35,75L40,68L42,60L38,52L35,45L32,38L28,30L30,20Z" fill="rgba(96,165,250,.03)" stroke="rgba(96,165,250,.1)" strokeWidth=".3"/>
          {[{a:55,b:28,c:48,d:52},{a:48,b:52,c:50,d:82},{a:55,b:28,c:55,d:18},{a:48,b:52,c:42,d:78},{a:44,b:65,c:50,d:82},{a:44,b:65,c:48,d:52}].map((r,i)=><line key={'r'+i} x1={r.a} y1={r.b} x2={r.c} y2={r.d} stroke="rgba(255,255,255,.07)" strokeWidth=".6" strokeLinecap="round"/>)}
          <rect x="40" y="62" width="10" height="5" rx="1" fill="rgba(248,113,113,.1)" stroke="rgba(248,113,113,.2)" strokeWidth=".2"/>
          <text x="45" y="65.2" textAnchor="middle" fill="#F87171" fontSize="2" fontWeight="bold">ก่อสร้าง</text>
          {[{n:'ขอนแก่น',x:55,y:28},{n:'นครราชสีมา',x:48,y:52},{n:'กรุงเทพฯ',x:50,y:82},{n:'อุดรธานี',x:55,y:18},{n:'ชลบุรี',x:42,y:78},{n:'สระบุรี',x:44,y:65}].map((ct,i)=>(<g key={'c'+i}><circle cx={ct.x} cy={ct.y} r="1" fill="rgba(255,255,255,.05)" stroke="rgba(255,255,255,.12)" strokeWidth=".2"/><text x={ct.x} y={ct.y-2.5} textAnchor="middle" fill="rgba(255,255,255,.3)" fontSize="2.5" fontWeight="bold">{ct.n}</text></g>))}
          {sv.map((v,i)=>(<g key={'l'+i}><line x1={55} y1={28} x2={v.x} y2={v.y} stroke={v.c} strokeWidth=".5" opacity=".4"/><line x1={v.x} y1={v.y} x2={v.tx} y2={v.ty} stroke={v.c} strokeWidth=".3" opacity=".15" strokeDasharray="1,1"/></g>))}
          {sv.map((v,i)=>{const jx=v.s>0?Math.sin(tick*.8+i)*.4:0;const jy=v.s>0?Math.cos(tick*.6+i)*.3:0;const isSel=sel===v.id;return(<g key={'p'+i} onClick={()=>setSel(isSel?null:v.id)} style={{cursor:'pointer'}}>{v.s>0&&<circle cx={v.x+jx} cy={v.y+jy} r="3" fill="none" stroke={v.c} strokeWidth=".3"><animate attributeName="r" values="1.5;4;1.5" dur="2.5s" repeatCount="indefinite"/><animate attributeName="opacity" values=".5;0;.5" dur="2.5s" repeatCount="indefinite"/></circle>}<ellipse cx={v.x+jx} cy={v.y+jy+1.5} rx="1.8" ry=".5" fill="rgba(0,0,0,.25)"/><circle cx={v.x+jx} cy={v.y+jy} r={isSel?2.5:1.8} fill={v.c} stroke="white" strokeWidth=".5"/><text x={v.x+jx} y={v.y+jy+.8} textAnchor="middle" fill="white" fontSize="2" fontWeight="bold">{v.n[0]}</text><rect x={v.x+jx+3} y={v.y+jy-2} width={mode==='single'?15:11} height="4" rx="1" fill="rgba(0,0,0,.7)" stroke={v.c} strokeWidth=".15"/><text x={v.x+jx+4} y={v.y+jy+.5} fill="white" fontSize="2" fontWeight="bold">{mode==='single'?v.r:v.n}</text>{v.s>0&&<g><rect x={v.x+jx+3} y={v.y+jy+2.5} width="8" height="3" rx=".8" fill={v.c}/><text x={v.x+jx+7} y={v.y+jy+4.5} textAnchor="middle" fill="white" fontSize="1.8" fontWeight="bold">{v.s}km/h</text></g>}</g>);})}
          <line x1="5" y1="95" x2="20" y2="95" stroke="rgba(255,255,255,.15)" strokeWidth=".3"/><text x="12.5" y="93.5" textAnchor="middle" fill="rgba(255,255,255,.15)" fontSize="2">100 km</text>
          <g transform="translate(92,8)"><circle r="3" fill="rgba(0,0,0,.25)" stroke="rgba(255,255,255,.08)" strokeWidth=".2"/><line x1="0" y1="1.5" x2="0" y2="-2" stroke="rgba(255,255,255,.3)" strokeWidth=".3"/><text x="0" y="-3" textAnchor="middle" fill="rgba(255,255,255,.25)" fontSize="1.5" fontWeight="bold">N</text></g>
        </svg>
        {sel&&(()=>{const v=sv.find(x=>x.id===sel);if(!v)return null;return(<div style={{position:'absolute',bottom:12,left:12,right:12,background:'rgba(10,22,40,.95)',border:'1px solid '+v.c+'30',borderRadius:12,padding:12,display:'flex',alignItems:'center',gap:12}}><div style={{width:40,height:40,borderRadius:12,background:v.c,display:'flex',alignItems:'center',justifyContent:'center',color:'white',fontSize:14,fontWeight:800,flexShrink:0}}>{v.n[0]}</div><div style={{flex:1}}><p className="text-sm text-white font-bold">{v.n} • {v.r}</p><p className="text-[13px] text-neutral-500">{v.rt} • {v.km} km</p><div className="flex gap-3 mt-1"><span className="text-[13px]"><span className="text-neutral-600">ความเร็ว </span><span style={{color:v.c}} className="font-bold">{v.s} km/h</span></span><span className="text-[13px] font-bold px-1.5 py-0.5 rounded" style={{background:v.c+'20',color:v.c}}>{v.st}</span></div></div><button onClick={e=>{e.stopPropagation();setSel(null);}} className="text-neutral-600 text-[13px] cursor-pointer">✕</button></div>);})()}
      </div>
      <div className="px-4 py-2 flex gap-3">
        <span className="flex items-center gap-1 text-[13px] text-neutral-500"><div className="w-2 h-2 rounded-full" style={{background:'#60A5FA'}}/> เดินทาง</span>
        <span className="flex items-center gap-1 text-[13px] text-neutral-500"><div className="w-2 h-2 rounded-full" style={{background:'#FBBF24'}}/> จอดพัก</span>
        <span className="flex items-center gap-1 text-[13px] text-neutral-500"><div className="w-2 h-2 rounded-full" style={{background:'#34D399'}}/> ถึงแล้ว</span>
        <span className="flex items-center gap-1 text-[13px] text-neutral-500"><div className="w-2 h-2 rounded-full" style={{background:'#F87171'}}/> จุดเสี่ยง</span>
        <span className="flex items-center gap-1 text-[13px] text-neutral-500 ml-auto"><div className="w-1.5 h-1.5 rounded-full" style={{background:'#34D399',animation:'bk 2s infinite'}}/> LIVE</span>
      </div>
    </div>
  );
}

/* ═══════════════════════════════════════════
   FORM QUESTION — renders each input type
   ═══════════════════════════════════════════ */
function FormQuestion({ current, answers, activeQ, isLast, onAnswer, onSkip }) {
  const [sq, setSq] = useState('');
  const [photoState, setPhotoState] = useState('idle');

  // ═══ SELECT
  if (current.type === 'select') {
    return (
      <div className="space-y-2">
        {current.opts.map((opt, i) => (
          <button key={i} onClick={() => onAnswer(opt)}
            className={`w-full text-left rounded-xl border p-4 text-lg transition-all cursor-pointer ${answers[activeQ] === opt ? 'border-yellow-400/30 bg-yellow-400/10 text-yellow-400' : 'border-white/5 bg-white/[0.02] text-white hover:border-yellow-400/20'}`}>
            {opt}
          </button>
        ))}
      </div>
    );
  }

  // ═══ SEARCH (vehicle/driver)
  if (current.type === 'search') {
    const items = (current.opts || []).filter(o => {
      if (!sq) return true;
      return o.replace(/[-\s]/g, '').toLowerCase().includes(sq.replace(/[-\s]/g, '').toLowerCase());
    });
    return (
      <div>
        <div className="relative mb-2">
          <svg viewBox="0 0 24 24" fill="none" className="absolute left-3 top-3 h-5 w-5 text-neutral-500" stroke="currentColor" strokeWidth="1.8"><circle cx="11" cy="11" r="7"/><path d="m16.5 16.5 4 4" strokeLinecap="round"/></svg>
          <input value={sq} onChange={e => setSq(e.target.value)} autoFocus
            className="w-full h-11 rounded-xl border border-white/10 bg-white/[0.03] pl-10 pr-4 text-base text-white outline-none focus:border-yellow-400 transition"
            placeholder={current.searchType === 'vehicle' ? 'พิมพ์ทะเบียน/ตัวเลข/จังหวัด' : 'พิมพ์ชื่อ/ทะเบียนรถ'} />
        </div>
        {sq && items.length === 0 && <p className="text-sm text-neutral-500 text-center py-4">ไม่พบ "{sq}"</p>}
        <div className="space-y-1.5" style={{maxHeight:280,overflowY:'auto'}}>
          {items.slice(0, 5).map((opt, i) => (
            <button key={i} onClick={() => onAnswer(opt)}
              className="w-full text-left rounded-xl p-3 flex items-center gap-3 cursor-pointer transition-all"
              style={{border:'1px solid rgba(255,255,255,0.06)',background:'rgba(255,255,255,0.02)'}}
              onMouseEnter={e=>{e.currentTarget.style.borderColor='rgba(251,191,36,0.3)';e.currentTarget.style.background='rgba(251,191,36,0.05)';}}
              onMouseLeave={e=>{e.currentTarget.style.borderColor='rgba(255,255,255,0.06)';e.currentTarget.style.background='rgba(255,255,255,0.02)';}}>
              <div className="w-8 h-8 rounded-lg flex items-center justify-center shrink-0" style={{background:current.searchType==='vehicle'?'rgba(96,165,250,0.1)':'rgba(251,191,36,0.1)'}}>
                <Icon type={current.searchType === 'vehicle' ? 'car' : 'users'} className="h-3.5 w-3.5" style={{color:current.searchType==='vehicle'?'#60A5FA':'#FBBF24'}} />
              </div>
              <span className="text-sm text-white font-medium">{opt}</span>
            </button>
          ))}
        </div>
        {items.length > 5 && <p className="text-[13px] text-neutral-600 text-center mt-2">อีก {items.length - 5} รายการ — พิมพ์เพิ่ม</p>}
      </div>
    );
  }

  // ═══ AUTO
  if (current.type === 'auto') {
    const autoVal = current.q === 'ต้นทาง' ? 'ขอนแก่น' : current.q === 'ปลายทาง' ? 'กรุงเทพฯ' : current.q.includes('ระยะทาง') ? '142 km' : current.q.includes('เวลา') ? new Date().toLocaleTimeString('th-TH',{hour:'2-digit',minute:'2-digit'}) : current.q.includes('ความเร็ว') ? '78 km/h' : '16.4321°N, 102.8365°E';
    return (
      <div className="rounded-xl border border-emerald-500/20 p-4 flex items-center gap-3" style={{background:'rgba(52,211,153,0.05)'}}>
        <div className="w-8 h-8 rounded-full bg-emerald-500/20 flex items-center justify-center"><Icon type="check" className="h-4 w-4 text-emerald-400"/></div>
        <div className="flex-1"><p className="text-sm text-emerald-400 font-medium">ดึงข้อมูลอัตโนมัติ</p><p className="text-[13px] text-neutral-500">{autoVal}</p></div>
        <button onClick={() => onAnswer(autoVal)} className="px-3 py-1.5 rounded-lg bg-emerald-500/20 text-emerald-400 text-sm font-bold cursor-pointer">ยืนยัน</button>
      </div>
    );
  }

  // ═══ PHOTO — camera or gallery with permission flow
  if (current.type === 'photo') {
    if (photoState === 'permission') {
      return (
        <div className="text-center py-8">
          <div className="w-14 h-14 rounded-2xl flex items-center justify-center mx-auto mb-3" style={{background:'rgba(251,191,36,0.1)'}}><Icon type="shield" className="h-6 w-6 text-yellow-400"/></div>
          <p className="text-base text-white font-bold mb-1">ขออนุญาตเข้าถึง</p>
          <p className="text-sm text-neutral-400">กล้องถ่ายรูป / คลังรูปภาพ</p>
          <div className="flex justify-center mt-4"><div className="w-8 h-8 rounded-full border-2 border-yellow-400 border-t-transparent" style={{animation:'spin 1s linear infinite'}}/></div>
          <p className="text-[13px] text-neutral-600 mt-2">รอการอนุญาต...</p>
        </div>
      );
    }
    if (photoState === 'preview') {
      return (
        <div>
          <div className="rounded-2xl overflow-hidden mb-3" style={{border:'1px solid rgba(52,211,153,0.2)'}}>
            <div style={{height:3,background:'linear-gradient(90deg,#34D399,transparent)'}}/>
            <div className="p-4 flex items-center gap-3" style={{background:'rgba(52,211,153,0.04)'}}>
              <div className="w-14 h-14 rounded-xl flex items-center justify-center" style={{background:'#1a1a1a',border:'1px solid rgba(255,255,255,0.1)'}}>
                <svg viewBox="0 0 24 24" fill="none" className="h-7 w-7 text-emerald-400" stroke="currentColor" strokeWidth="1.5"><rect x="3" y="3" width="18" height="18" rx="2.5"/><circle cx="8.5" cy="8.5" r="2"/><path d="m3 16 5-5a2 2 0 0 1 2.8 0L15 15"/></svg>
              </div>
              <div className="flex-1"><p className="text-sm text-emerald-400 font-bold">ถ่ายรูปสำเร็จ!</p><p className="text-[13px] text-neutral-500">IMG_{new Date().toISOString().slice(0,10).replace(/-/g,'')}.jpg</p></div>
              <Icon type="check" className="h-5 w-5 text-emerald-400"/>
            </div>
          </div>
          <div className="flex gap-2">
            <button onClick={() => setPhotoState('idle')} className="flex-1 h-10 rounded-xl text-sm cursor-pointer" style={{border:'1px solid rgba(255,255,255,0.08)',color:'rgba(255,255,255,0.5)'}}>ถ่ายใหม่</button>
            <button onClick={() => onAnswer('photo-taken')} className="flex-1 h-10 rounded-xl text-sm font-bold cursor-pointer" style={{background:'linear-gradient(135deg,#34D399,#10B981)',color:'white'}}>{isLast ? 'ส่งฟอร์ม' : 'ใช้รูปนี้ →'}</button>
          </div>
        </div>
      );
    }
    return (
      <div>
        <div className="rounded-xl p-3 mb-3 flex items-center gap-2" style={{background:'rgba(251,191,36,0.06)',border:'1px solid rgba(251,191,36,0.1)'}}>
          <Icon type="shield" className="h-3.5 w-3.5 text-yellow-400 shrink-0"/>
          <p className="text-[13px] text-neutral-400">ระบบจะขออนุญาตเข้าถึงกล้องหรือคลังรูปภาพ</p>
        </div>
        <div className="grid grid-cols-2 gap-3 mb-3">
          <button onClick={() => { setPhotoState('permission'); setTimeout(() => setPhotoState('preview'), 2000); }}
            className="rounded-2xl p-5 text-center cursor-pointer transition-all" style={{border:'1px solid rgba(96,165,250,0.15)',background:'rgba(96,165,250,0.04)'}}
            onMouseEnter={e=>{e.currentTarget.style.borderColor='rgba(96,165,250,0.3)';e.currentTarget.style.transform='translateY(-2px)';}}
            onMouseLeave={e=>{e.currentTarget.style.borderColor='rgba(96,165,250,0.15)';e.currentTarget.style.transform='';}}>
            <div className="w-12 h-12 rounded-xl flex items-center justify-center mx-auto mb-2" style={{background:'rgba(96,165,250,0.15)'}}>
              <svg viewBox="0 0 24 24" fill="none" className="h-6 w-6 text-sky-400" stroke="currentColor" strokeWidth="1.5"><rect x="2" y="6" width="20" height="14" rx="2.5"/><circle cx="12" cy="13" r="4"/><path d="M7 6V4.5a1 1 0 0 1 1-1h2.5l1 2"/></svg>
            </div>
            <p className="text-sm text-sky-400 font-bold">ถ่ายรูป</p>
            <p className="text-[13px] text-neutral-500">เปิดกล้องถ่ายทันที</p>
          </button>
          <button onClick={() => { setPhotoState('permission'); setTimeout(() => setPhotoState('preview'), 1500); }}
            className="rounded-2xl p-5 text-center cursor-pointer transition-all" style={{border:'1px solid rgba(167,139,250,0.15)',background:'rgba(167,139,250,0.04)'}}
            onMouseEnter={e=>{e.currentTarget.style.borderColor='rgba(167,139,250,0.3)';e.currentTarget.style.transform='translateY(-2px)';}}
            onMouseLeave={e=>{e.currentTarget.style.borderColor='rgba(167,139,250,0.15)';e.currentTarget.style.transform='';}}>
            <div className="w-12 h-12 rounded-xl flex items-center justify-center mx-auto mb-2" style={{background:'rgba(167,139,250,0.15)'}}>
              <svg viewBox="0 0 24 24" fill="none" className="h-6 w-6 text-purple-400" stroke="currentColor" strokeWidth="1.5"><rect x="3" y="3" width="18" height="18" rx="2.5"/><circle cx="8.5" cy="8.5" r="2"/><path d="m3 16 5-5a2 2 0 0 1 2.8 0L15 15"/></svg>
            </div>
            <p className="text-sm text-purple-400 font-bold">เลือกจากคลัง</p>
            <p className="text-[13px] text-neutral-500">อัลบั้มรูปภาพ</p>
          </button>
        </div>
        <button onClick={() => onSkip()} className="w-full h-10 rounded-xl text-sm cursor-pointer" style={{background:'rgba(255,255,255,0.03)',border:'1px solid rgba(255,255,255,0.06)',color:'rgba(255,255,255,0.4)'}}>ข้ามข้อนี้ →</button>
      </div>
    );
  }

  // ═══ NOTE (optional remark)
  if (current.type === 'note') {
    return (
      <div>
        <div className="flex flex-wrap gap-2 mb-3">
          {(current.presets || ['ไม่มี','อื่นๆ']).map((p,i) => (
            <button key={i} onClick={() => onAnswer(p)}
              className="px-4 py-2.5 rounded-xl text-sm font-medium cursor-pointer transition-all"
              style={{border:'1px solid rgba(255,255,255,0.08)',background:'rgba(255,255,255,0.02)',color:'white'}}
              onMouseEnter={e=>{e.currentTarget.style.borderColor='rgba(251,191,36,0.3)';e.currentTarget.style.background='rgba(251,191,36,0.06)';}}
              onMouseLeave={e=>{e.currentTarget.style.borderColor='rgba(255,255,255,0.08)';e.currentTarget.style.background='rgba(255,255,255,0.02)';}}>{p}</button>
          ))}
        </div>
        <div className="flex items-center gap-2 mb-2"><div style={{flex:1,height:1,background:'rgba(255,255,255,0.06)'}}/><span className="text-[13px] text-neutral-600">หรือพิมพ์เอง</span><div style={{flex:1,height:1,background:'rgba(255,255,255,0.06)'}}/></div>
        <input className="h-11 w-full rounded-xl border border-white/10 bg-white/[0.03] px-4 text-sm text-white outline-none focus:border-yellow-400 transition mb-3" placeholder="พิมพ์หมายเหตุ (ถ้ามี)..." />
        <button onClick={() => onSkip()} className="w-full h-10 rounded-xl text-sm cursor-pointer" style={{background:'rgba(255,255,255,0.03)',border:'1px solid rgba(255,255,255,0.06)',color:'rgba(255,255,255,0.4)'}}>{isLast ? 'ส่งฟอร์ม →' : 'ข้ามข้อนี้ →'}</button>
      </div>
    );
  }

  // ═══ FALLBACK (text)
  return (
    <div>
      <input className="h-12 w-full rounded-xl border border-white/10 bg-white/5 px-4 text-base text-white outline-none focus:border-yellow-400 transition mb-3" placeholder="พิมพ์คำตอบ..." />
      <button onClick={() => onSkip()} className="w-full h-11 rounded-xl bg-yellow-400 text-neutral-900 font-bold cursor-pointer hover:bg-yellow-300 transition">{isLast ? 'ส่งฟอร์ม' : 'ถัดไป →'}</button>
    </div>
  );
}

function FormListView() {
  const [formStates, setFormStates] = useState(() => {
    const s = {};
    FORMS.forEach(f => { s[f.id] = { enabled: true, done: false, score: 0 }; });
    return s;
  });
  const [activeForm, setActiveForm] = useState(null);
  const [activeQ, setActiveQ] = useState(0);
  const [answers, setAnswers] = useState({});
  const [celebration, setCelebration] = useState(null);
  const [showFW, setShowFW] = useState(false);
  const [gpsStep, setGpsStep] = useState(0);

  const totalScore = Object.values(formStates).reduce((sum, s) => sum + s.score, 0);
  const doneCount = Object.values(formStates).filter(s => s.done).length;

  // GPS auto-fill simulation
  React.useEffect(() => {
    if (activeForm && FORMS.find(f => f.id === activeForm)?.gps && gpsStep === 0) {
      setGpsStep(1);
      const t1 = setTimeout(() => setGpsStep(2), 800);
      const t2 = setTimeout(() => setGpsStep(3), 1500);
      return () => { clearTimeout(t1); clearTimeout(t2); };
    }
  }, [activeForm]);

  // Celebration fireworks
  React.useEffect(() => {
    if (showFW) {
      const t = setTimeout(() => setShowFW(false), 2500);
      return () => clearTimeout(t);
    }
  }, [showFW]);

  // Active form mode — one question at a time
  if (activeForm) {
    const form = FORMS.find(f => f.id === activeForm);
    const qs = FORM_QS[activeForm] || [{q:'ข้อมูลทั่วไป',type:'select',opts:['ปกติ','ผิดปกติ']},{q:'หมายเหตุ (ข้ามได้)',type:'note',presets:['ไม่มี','รถสกปรก','ต้องซ่อม','อื่นๆ']}];
    const current = qs[activeQ];
    const isLast = activeQ >= qs.length - 1;
    const progress = ((activeQ + 1) / qs.length) * 100;

    return (
      <div>
        {/* Header with back to previous question */}
        <div className="flex items-center justify-between mb-4">
          <div className="flex items-center gap-3">
            <button onClick={() => { setActiveForm(null); setActiveQ(0); setAnswers({}); setGpsStep(0); }}
              className="text-sm text-neutral-500 hover:text-white cursor-pointer">✕</button>
            {activeQ > 0 && (
              <button onClick={() => setActiveQ(prev => prev - 1)}
                className="flex items-center gap-1.5 text-sm text-yellow-400 hover:text-yellow-300 cursor-pointer transition-colors">
                <svg viewBox="0 0 12 12" className="h-3.5 w-3.5"><path d="M7.5 2.5l-4 4 4 4" fill="none" stroke="currentColor" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round"/></svg>
                ข้อก่อนหน้า
              </button>
            )}
          </div>
          <div className="flex items-center gap-2">
            <span className="text-[13px] text-emerald-500">บันทึกอัตโนมัติ</span>
            <span className="text-sm text-neutral-500">ข้อ {activeQ + 1}/{qs.length}</span>
          </div>
        </div>

        {/* Progress bar — clickable dots */}
        <div className="flex items-center gap-1 mb-4">
          {qs.map((q, i) => (
            <div key={i} onClick={() => { if (i < activeQ || answers[i]) setActiveQ(i); }}
              className="flex-1 h-2 rounded-full transition-all duration-300 cursor-pointer"
              style={{background: i < activeQ ? '#34D399' : i === activeQ ? '#FBBF24' : 'rgba(255,255,255,0.08)'}}
              title={`ข้อ ${i+1}: ${q.q}`} />
          ))}
        </div>

        {/* Tracking reminder — for Check-in forms */}
        {(activeForm === 'F05' || activeForm === 'F06') && (
          <div className="rounded-xl p-3 mb-3 flex items-center gap-3" style={{border:'1px solid rgba(96,165,250,0.15)',background:'rgba(96,165,250,0.04)'}}>
            <div className="w-8 h-8 rounded-lg flex items-center justify-center shrink-0" style={{background:'rgba(96,165,250,0.15)'}}>
              <Icon type="route" className="h-4 w-4 text-sky-400"/>
            </div>
            <div className="flex-1">
              <p className="text-sm text-sky-400 font-medium">GPS Tracking อัตโนมัติ</p>
              <p className="text-[13px] text-neutral-500">ทุกข้อดึงจาก GPS อัตโนมัติ — กดยืนยันทีเดียวจบ</p>
            </div>
          </div>
        )}

        {/* Auto-save notice */}
        <div className="rounded-lg p-2 mb-3 flex items-center gap-2" style={{background:'rgba(52,211,153,0.04)',border:'1px solid rgba(52,211,153,0.08)'}}>
          <div className="w-1.5 h-1.5 rounded-full bg-emerald-400 shrink-0"/>
          <p className="text-[13px] text-neutral-500">ตอบไปถึงไหน ระบบบันทึกไว้แล้ว — <span className="text-emerald-400">กลับมาทำต่อได้ ไม่เริ่มใหม่</span></p>
        </div>

        {/* GPS auto-fill */}
        {form.gps && gpsStep < 3 && (
          <div className="rounded-xl border border-sky-500/20 bg-sky-500/5 p-3 mb-4 flex items-center gap-3">
            <div className={`w-8 h-8 rounded-full bg-sky-500/20 flex items-center justify-center ${gpsStep < 3 ? 'animate-pulse' : ''}`}>
              <Icon type="route" className="h-4 w-4 text-sky-400" />
            </div>
            <div>
              <p className="text-sm text-sky-400 font-medium">{gpsStep === 1 ? 'กำลังหาตำแหน่ง...' : 'กำลังดึงข้อมูล GPS...'}</p>
            </div>
          </div>
        )}
        {form.gps && gpsStep >= 3 && (
          <div className="rounded-xl border border-emerald-500/20 bg-emerald-500/5 p-3 mb-4 flex items-center gap-3">
            <div className="w-8 h-8 rounded-full bg-emerald-500/20 flex items-center justify-center">
              <Icon type="check" className="h-4 w-4 text-emerald-400" />
            </div>
            <div>
              <p className="text-sm text-emerald-400 font-medium">GPS auto-fill สำเร็จ</p>
              <p className="text-[13px] text-neutral-500">16.4321°N, 102.8365°E • ขอนแก่น</p>
            </div>
          </div>
        )}

        {/* Form name */}
        <div className="rounded-xl border border-white/5 bg-white/[0.02] p-5 mb-4">
          <p className="text-base font-bold text-yellow-400 mb-1">{form.name}</p>
          <p className="text-sm text-neutral-500">Tier {form.tier}: {TIER_NAMES[form.tier]}</p>
        </div>

        {/* Current question */}
        <div className="rounded-xl border border-yellow-400/15 bg-yellow-400/[0.03] p-5 mb-4">
          <p className="text-lg font-bold text-white mb-4">{current.q}</p>
          <FormQuestion current={current} answers={answers} activeQ={activeQ} isLast={isLast}
            onAnswer={(val) => {
              setAnswers(prev => ({...prev, [activeQ]: val}));
              if (isLast) {
                setFormStates(prev => ({...prev, [activeForm]: { ...prev[activeForm], done: true, score: form.points }}));
                setCelebration({ form, points: form.points }); setShowFW(true); if(window._addRecent) window._addRecent('form', form.name, 'documentsForms');
                setActiveForm(null); setActiveQ(0); setAnswers({}); setGpsStep(0);
              } else { setTimeout(() => setActiveQ(prev => prev + 1), 200); }
            }}
            onSkip={() => {
              if (isLast) {
                setFormStates(prev => ({...prev, [activeForm]: { ...prev[activeForm], done: true, score: form.points }}));
                setCelebration({ form, points: form.points }); setShowFW(true); if(window._addRecent) window._addRecent('form', form.name, 'documentsForms');
                setActiveForm(null); setActiveQ(0); setAnswers({}); setGpsStep(0);
              } else { setActiveQ(prev => prev + 1); }
            }} />
        </div>
      </div>
    );
  }

  // Gamification levels
  const levels = [{min:0,name:'เริ่มต้น',icon:'🌱',next:50},{min:50,name:'มือใหม่',icon:'⭐',next:120},{min:120,name:'ชำนาญ',icon:'🔥',next:200},{min:200,name:'เชี่ยวชาญ',icon:'💎',next:300},{min:300,name:'ระดับเพชร',icon:'👑',next:999}];
  const currentLevel = [...levels].reverse().find(l => totalScore >= l.min) || levels[0];
  const nextLevel = levels[levels.indexOf(currentLevel) + 1] || currentLevel;
  const levelProgress = nextLevel.next > currentLevel.min ? Math.round(((totalScore - currentLevel.min) / (nextLevel.next - currentLevel.min)) * 100) : 100;
  const streak = doneCount;
  const badges = [];
  if (doneCount >= 1) badges.push({name:'เริ่มต้นดี',icon:'🎯',desc:'ทำฟอร์มแรกสำเร็จ'});
  if (doneCount >= 5) badges.push({name:'ขยันเกินร้อย',icon:'💪',desc:'ทำ 5 ฟอร์มแล้ว'});
  if (doneCount >= 10) badges.push({name:'นักปฏิบัติ',icon:'🏆',desc:'ทำ 10 ฟอร์มแล้ว'});
  if (totalScore >= 100) badges.push({name:'ร้อยแต้ม',icon:'💯',desc:'สะสม 100 คะแนน'});
  if (totalScore >= 200) badges.push({name:'ดาวทอง',icon:'🌟',desc:'สะสม 200 คะแนน'});

  // Celebration modal
  if (celebration) {
    const newBadge = badges.length > 0 ? badges[badges.length - 1] : null;
    return (
      <div className="flex flex-col items-center justify-center py-8 text-center">
        {showFW && <Fireworks />}

        {/* Points earned */}
        <div className="rounded-2xl p-5 mb-4 w-full max-w-xs" style={{background:'linear-gradient(135deg,rgba(251,191,36,0.08),transparent)',border:'1px solid rgba(251,191,36,0.15)'}}>
          <p className="text-base text-white font-bold mb-1">{celebration.form.name}</p>
          <p className="text-3xl font-black text-yellow-400 mb-2">+{celebration.points} คะแนน</p>
          <div className="flex items-center gap-2 justify-center">
            <span className="text-xl">{currentLevel.icon}</span>
            <span className="text-sm text-yellow-400 font-bold">{currentLevel.name}</span>
          </div>
        </div>

        {/* Level progress */}
        <div className="w-full max-w-xs mb-4">
          <div className="flex justify-between text-[13px] text-neutral-500 mb-1">
            <span>{currentLevel.name}</span>
            <span>{totalScore}/{nextLevel.next}</span>
          </div>
          <div className="h-2 rounded-full bg-neutral-800 overflow-hidden">
            <div className="h-full rounded-full transition-all" style={{width:`${levelProgress}%`,background:'linear-gradient(90deg,#FBBF24,#F59E0B)'}}/>
          </div>
          {nextLevel !== currentLevel && <p className="text-[13px] text-neutral-600 mt-1">อีก {nextLevel.next - totalScore} คะแนนถึง {nextLevel.icon} {nextLevel.name}</p>}
        </div>

        {/* Stats row */}
        <div className="flex gap-3 w-full max-w-xs mb-4">
          <div className="flex-1 rounded-xl p-2.5 text-center" style={{background:'rgba(255,255,255,0.03)',border:'1px solid rgba(255,255,255,0.05)'}}>
            <p className="text-xl font-black text-yellow-400">{totalScore}</p>
            <p className="text-[13px] text-neutral-500">คะแนนรวม</p>
          </div>
          <div className="flex-1 rounded-xl p-2.5 text-center" style={{background:'rgba(255,255,255,0.03)',border:'1px solid rgba(255,255,255,0.05)'}}>
            <p className="text-xl font-black text-emerald-400">{doneCount}</p>
            <p className="text-[13px] text-neutral-500">ฟอร์มเสร็จ</p>
          </div>
          <div className="flex-1 rounded-xl p-2.5 text-center" style={{background:'rgba(255,255,255,0.03)',border:'1px solid rgba(255,255,255,0.05)'}}>
            <p className="text-xl font-black text-purple-400">{badges.length}</p>
            <p className="text-[13px] text-neutral-500">เหรียญ</p>
          </div>
        </div>

        {/* New badge earned */}
        {newBadge && doneCount <= 1 || (celebration.points + (totalScore - celebration.points) < 100 && totalScore >= 100) || (celebration.points + (totalScore - celebration.points) < 200 && totalScore >= 200) ? (
          <div className="rounded-2xl p-3 mb-4 w-full max-w-xs flex items-center gap-3" style={{background:'linear-gradient(135deg,rgba(167,139,250,0.1),transparent)',border:'1px solid rgba(167,139,250,0.2)'}}>
            <span className="text-2xl">{newBadge?.icon || '🎯'}</span>
            <div className="text-left"><p className="text-sm text-purple-400 font-bold">เหรียญใหม่!</p><p className="text-[13px] text-neutral-400">{newBadge?.name || ''} — {newBadge?.desc || ''}</p></div>
          </div>
        ) : null}

        <button onClick={() => setCelebration(null)}
          className="px-6 py-2.5 rounded-xl font-bold cursor-pointer hover:opacity-90 transition" style={{background:'linear-gradient(135deg,#FBBF24,#F59E0B)',color:'#1a1a1a'}}>
          ทำฟอร์มต่อ
        </button>
      </div>
    );
  }

  // Form list
  return (
    <div>
      {/* Score + Level header */}
      <div className="rounded-2xl p-4 mb-4" style={{border:'1px solid rgba(251,191,36,0.1)',background:'linear-gradient(135deg,rgba(251,191,36,0.04),transparent)'}}>
        <div className="flex items-center justify-between mb-3">
          <div className="flex items-center gap-2">
            <span className="text-xl">{currentLevel.icon}</span>
            <div>
              <p className="text-sm font-bold text-yellow-400">{currentLevel.name}</p>
              <p className="text-[13px] text-neutral-500">ฟอร์มเสร็จ {doneCount}/{FORMS.length}</p>
            </div>
          </div>
          <div className="text-right">
            <p className="text-2xl font-black text-yellow-400">{totalScore}</p>
            <p className="text-[13px] text-neutral-500">คะแนนสะสม</p>
          </div>
        </div>
        <div className="h-2 rounded-full bg-neutral-800 overflow-hidden mb-1">
          <div className="h-full rounded-full" style={{width:`${levelProgress}%`,background:'linear-gradient(90deg,#FBBF24,#F59E0B)',transition:'width 0.5s'}}/>
        </div>
        <div className="flex justify-between">
          <p className="text-[13px] text-neutral-600">{currentLevel.name}</p>
          <p className="text-[13px] text-neutral-600">{nextLevel !== currentLevel ? nextLevel.icon+' '+nextLevel.name+' ('+nextLevel.next+')' : 'สูงสุดแล้ว!'}</p>
        </div>
        {badges.length > 0 && (
          <div className="flex gap-2 mt-3 pt-3" style={{borderTop:'1px solid rgba(255,255,255,0.04)'}}>
            <p className="text-[13px] text-neutral-600 shrink-0 pt-0.5">เหรียญ:</p>
            <div className="flex gap-1.5 flex-wrap">
              {badges.map((b,i) => (
                <span key={i} className="text-sm cursor-pointer" title={b.name + ' — ' + b.desc}
                  onMouseEnter={e=>{e.currentTarget.style.transform='scale(1.3)';}} onMouseLeave={e=>{e.currentTarget.style.transform='scale(1)';}}
                  style={{transition:'transform 0.15s'}}>{b.icon}</span>
              ))}
            </div>
          </div>
        )}
      </div>

      {/* Tier groups */}
      {[1, 2, 3, 4, 5, 0].map(tier => {
        const tierForms = FORMS.filter(f => f.tier === tier);
        if (tierForms.length === 0) return null;
        return (
          <div key={tier} className="mb-4">
            <p className="text-base font-bold text-yellow-400 mb-2">
              {tier === 0 ? '📋 บริหาร' : `Tier ${tier}: ${TIER_NAMES[tier]}`}
            </p>
            <div className="space-y-2">
              {tierForms.map(form => {
                const state = formStates[form.id];
                return (
                  <button key={form.id} onClick={() => { if (!state.done) { setActiveForm(form.id); setActiveQ(0); setGpsStep(0); } }}
                    className={`w-full text-left rounded-xl border p-3 flex items-center gap-3 transition-all cursor-pointer ${state.done ? 'border-emerald-500/20 bg-emerald-500/[0.03]' : 'border-white/5 bg-white/[0.02] hover:border-yellow-400/20'}`}>
                    <div className={`w-9 h-9 rounded-lg flex items-center justify-center shrink-0 ${state.done ? 'bg-emerald-500/20' : 'bg-white/5'}`}>
                      {state.done ? <span className="text-emerald-400 text-lg">✓</span> : <Icon type={form.icon} className="h-4 w-4 text-neutral-400" />}
                    </div>
                    <div className="flex-1 min-w-0">
                      <p className={`text-sm font-medium ${state.done ? 'text-emerald-400' : 'text-white'}`}>{form.name}</p>
                      <p className="text-[13px] text-neutral-500">{form.fields} ช่อง • {form.points} คะแนน {form.gps ? '• 📍 GPS' : ''}</p>
                    </div>
                    {state.done ? (
                      <div className="flex items-center gap-1.5 shrink-0">
                        <span className="text-sm text-emerald-400">+{state.score}</span>
                        <span className="text-[13px] font-bold px-2 py-0.5 rounded-lg" style={{background:'rgba(52,211,153,0.15)',color:'#34D399'}}>สำเร็จ</span>
                      </div>
                    ) : (
                      <div className="flex items-center gap-1.5 shrink-0">
                        <span className="text-[13px] font-bold px-2 py-0.5 rounded-lg" style={{background:'rgba(255,255,255,0.04)',color:'rgba(255,255,255,0.3)'}}>บันทึก</span>
                        <Icon type="arrowRight" className="h-4 w-4 text-neutral-600" />
                      </div>
                    )}
                  </button>
                );
              })}
            </div>
          </div>
        );
      })}
    </div>
  );
}

/* ═══════════════════════════════════════════
   ASSIGN WORK VIEW — จ่ายงาน 3 ขั้นตอน + QR
   ═══════════════════════════════════════════ */
/* ═══════════════════════════════════════════
   ORG DATA VIEW — จัดการข้อมูล 12 sub-pages
   ═══════════════════════════════════════════ */
/* ═══════════════════════════════════════════
   NOTIFICATIONS — badge + panel
   ═══════════════════════════════════════════ */
function getNotifications(role) {
  if (role === 'tsm') return [
    {id:'n1',menu:'assignWork',text:'นภา บริหาร จ่ายงานใหม่ 3 รายการ',level:'urgent',cat:'งานเข้า',time:'2 นาทีที่แล้ว'},
    {id:'n2',menu:'dailyOps',text:'ประเสริฐ ยังไม่ทำ ROLLCALL เกิน 30 นาที',level:'warn',cat:'ด่วน',time:'07:55'},
    {id:'n3',menu:'orgData',text:'พ.ร.บ. รถ บบ-7765 หมดอายุแล้ว 14 วัน',level:'urgent',cat:'เอกสาร',time:'วันนี้'},
    {id:'n4',menu:'reports',text:'รายงานไตรมาส 1 พร้อมส่งกรมฯ',level:'info',cat:'รายงาน',time:'08:00'},
    {id:'n5',menu:'documentsForms',text:'ฟอร์ม F10 แผนบำรุงรักษา ค้าง 2 รายการ',level:'warn',cat:'ฟอร์ม',time:'เมื่อวาน'},
    {id:'n6',menu:'knowledge',text:'วิชัย ยังไม่ผ่านอบรม ห้ามขับ',level:'urgent',cat:'อบรม',time:'3 วันที่แล้ว'},
    {id:'n7',menu:'assignWork',text:'สุรชัย ทำ ROLLCALL เสร็จแล้ว',level:'success',cat:'สำเร็จ',time:'08:10'},
  ];
  if (role === 'manager') return [
    {id:'n10',menu:'tracking',text:'รถ 80-4517 ภาษีเหลือ 12 วัน',level:'warn',cat:'เอกสาร',time:'วันนี้'},
    {id:'n11',menu:'fleetPeople',text:'ประเสริฐ ถึงกรุงเทพฯ แล้ว',level:'success',cat:'สำเร็จ',time:'13:20'},
    {id:'n12',menu:'reports',text:'คะแนนความปลอดภัย Q1 = 90/100',level:'info',cat:'รายงาน',time:'08:00'},
  ];
  if (role === 'fleet') return [
    {id:'n20',menu:'myWork',text:'ROLLCALL ก่อนงาน รอทำ',level:'warn',cat:'ด่วน',time:'07:30'},
    {id:'n21',menu:'myWork',text:'TSM สมชาย จ่ายงาน 3 ฟอร์ม',level:'info',cat:'งานเข้า',time:'07:25'},
    {id:'n22',menu:'myWork',text:'แจ้งเตือน: Check-in เวลา 12:00',level:'info',cat:'แจ้งเตือน',time:'ล่วงหน้า'},
  ];
  return [{id:'n30',menu:'myForms',text:'ฟอร์มที่ได้รับ 2 รายการ',level:'info',cat:'งานเข้า',time:'วันนี้'}];
}

function NotifBadge({ count }) {
  if (!count || count <= 0) return null;
  return (
    <span className="absolute -top-0.5 -right-0.5">
      <span className="absolute inset-0 w-5 h-5 rounded-full bg-red-500 opacity-40" style={{animation:'pulse 2s ease-in-out infinite'}}/>
      <span className="relative w-5 h-5 rounded-full bg-red-500 text-white text-[13px] font-bold flex items-center justify-center" style={{boxShadow:'0 0 8px rgba(239,68,68,0.5)'}}>
        {count > 9 ? '9+' : count}
      </span>
      <style>{`@keyframes pulse{0%,100%{transform:scale(1);opacity:0.4}50%{transform:scale(1.8);opacity:0}}`}</style>
    </span>
  );
}

function NotifPanel({ role, show, onClose, dismissed, onDismiss, onNavigate }) {
  if (!show) return null;
  const notifs = getNotifications(role).filter(n => !dismissed.includes(n.id));
  const urgentCount = notifs.filter(n => n.level === 'urgent').length;
  const levelColors = {urgent:'#F87171',warn:'#FBBF24',info:'#60A5FA',success:'#34D399'};
  const levelIcons = {urgent:'incident',warn:'bell',info:'send',success:'check'};
  return (
    <div className="absolute right-0 top-full mt-2 w-[400px] rounded-2xl z-50 overflow-hidden" style={{background:'#0f1d32',border:'1px solid rgba(255,255,255,0.08)',boxShadow:'0 8px 40px rgba(0,0,0,0.5)'}}>
      {/* Header */}
      <div className="px-4 py-3 flex items-center justify-between" style={{background:'linear-gradient(135deg,#FBBF24,#F59E0B)'}}>
        <div className="flex items-center gap-2">
          <Icon type="bell" className="h-4 w-4" style={{color:'#1a1a1a'}}/>
          <p style={{fontSize:14,fontWeight:800,color:'#1a1a1a',margin:0}}>แจ้งเตือน</p>
          <span style={{fontSize:13,fontWeight:700,color:'rgba(0,0,0,0.4)'}}>{notifs.length}</span>
        </div>
        <button onClick={onClose} style={{fontSize:13,fontWeight:700,color:'rgba(0,0,0,0.4)',cursor:'pointer',background:'none',border:'none'}}>ปิด ✕</button>
      </div>
      {/* Urgent banner */}
      {urgentCount > 0 && (
        <div className="px-4 py-2 flex items-center gap-2" style={{background:'rgba(248,113,113,0.08)',borderBottom:'1px solid rgba(248,113,113,0.1)'}}>
          <div className="w-2 h-2 rounded-full bg-red-400 shrink-0" style={{animation:'pulse 2s ease-in-out infinite'}}/>
          <p className="text-[13px] text-red-400 font-bold">{urgentCount} เรื่องเร่งด่วน ต้องดำเนินการ</p>
        </div>
      )}
      {/* Notification list */}
      <div style={{maxHeight:360,overflowY:'auto'}} className="p-2">
        {notifs.length === 0 && (
          <div className="text-center py-8">
            <Icon type="check" className="h-8 w-8 text-emerald-400 mx-auto mb-2" style={{opacity:0.5}}/>
            <p className="text-sm text-neutral-500">ไม่มีแจ้งเตือน</p>
          </div>
        )}
        {notifs.map(n => {
          const cl = levelColors[n.level] || '#60A5FA';
          return (
          <div key={n.id} className="rounded-xl p-3 mb-1.5 flex items-start gap-3 cursor-pointer transition-all duration-150"
            style={{background:'rgba(255,255,255,0.02)',border:'1px solid rgba(255,255,255,0.04)',borderLeft:'3px solid '+cl}}
            onClick={() => { onNavigate(n.menu); onDismiss(n.id); }}
            onMouseEnter={e=>{e.currentTarget.style.background='rgba(255,255,255,0.04)';e.currentTarget.style.paddingLeft='16px';}}
            onMouseLeave={e=>{e.currentTarget.style.background='rgba(255,255,255,0.02)';e.currentTarget.style.paddingLeft='12px';}}>
            <div className="w-8 h-8 rounded-xl flex items-center justify-center shrink-0 mt-0.5" style={{background:cl+'15'}}>
              <Icon type={levelIcons[n.level]||'bell'} className="h-3.5 w-3.5" style={{color:cl}}/>
            </div>
            <div className="flex-1 min-w-0">
              <div className="flex items-center gap-1.5 mb-0.5">
                <span className="text-[13px] font-bold px-1.5 py-0.5 rounded" style={{background:cl+'15',color:cl}}>{n.cat}</span>
                <span className="text-[13px] text-neutral-600">{n.time}</span>
              </div>
              <p className="text-sm text-white">{n.text}</p>
            </div>
            <button onClick={(e) => { e.stopPropagation(); onDismiss(n.id); }}
              className="text-neutral-600 hover:text-white text-[13px] cursor-pointer shrink-0 mt-1">✕</button>
          </div>
          );
        })}
      </div>
      {/* Footer */}
      {notifs.length > 0 && (
        <div className="px-4 py-2.5 flex items-center justify-between" style={{borderTop:'1px solid rgba(255,255,255,0.04)'}}>
          <button onClick={() => notifs.forEach(n => onDismiss(n.id))}
            className="text-[13px] text-neutral-500 cursor-pointer hover:text-white transition-colors" style={{background:'none',border:'none'}}>ปิดทั้งหมด</button>
          <button onClick={() => { onNavigate('dailyOps'); onClose(); }}
            className="text-[13px] font-bold cursor-pointer" style={{background:'none',border:'none',color:'#FBBF24'}}>ดูงานทั้งหมด →</button>
        </div>
      )}
    </div>
  );
}

function OrgDataView({ setupStep, setSetupStep }) {
  const [subPage, setSubPage] = useState(null);
  const [importPhase, setImportPhase] = useState(0);
  const [dupCount, setDupCount] = useState(0);
  const [matchPhase, setMatchPhase] = useState(0);
  const [fillPhase, setFillPhase] = useState(null);
  const [fillIdx, setFillIdx] = useState(0);
  const [vSearch, setVSearch] = useState('');
  const [vFilter, setVFilter] = useState('all');
  const [uSearch, setUSearch] = useState('');
  const [uFilter, setUFilter] = useState('all');

  const BackBtn = ({label}) => (
    <button onClick={() => setSubPage(null)} className="text-sm text-neutral-400 hover:text-white cursor-pointer mb-4 block">← {label || 'กลับ'}</button>
  );

  // ═══ Import sub-page
  if (subPage === 'import_data') {
    const gapFields = [
      {vehicle:'กน-1658 กรุงเทพ',missing:['น้ำหนักบรรทุกสูงสุด','วันหมด พ.ร.บ.']},
      {vehicle:'80-4517 ชลบุรี',missing:['ชื่อผู้ขับประจำ','วันหมด พ.ร.บ.','ประเภทเชื้อเพลิง']},
    ];
    const gapDrivers = [
      {driver:'วิชัย ส่งด่วน',missing:['เลขใบขับขี่','วันหมดอายุใบขับขี่']},
      {driver:'ธนา เดินทาง',missing:['เบอร์ติดต่อฉุกเฉิน']},
    ];
    const totalGaps = gapFields.reduce((s,g) => s+g.missing.length, 0) + gapDrivers.reduce((s,g) => s+g.missing.length, 0);
    const stepLabels = ['Template','อัปโหลด','ตรวจสอบ','เสริมข้อมูล'];
    return (
      <div>
        <BackBtn label="กลับจัดการข้อมูล" />
        <div className="flex gap-1.5 mb-4">
          {stepLabels.map((sl,si) => {
            const active = importPhase===0?si<2:importPhase===1?si===2:fillPhase?si===3:si===2;
            const done = importPhase===0?false:importPhase===1?si<2:fillPhase?si<3:si<2;
            return (<div key={si} className="flex-1"><div className="h-1.5 rounded-full mb-1" style={{background:done?'#34D399':active?'#FBBF24':'rgba(255,255,255,0.06)'}}/><p className="text-[13px] text-center" style={{color:done?'#34D399':active?'#FBBF24':'rgba(255,255,255,0.2)'}}>{sl}</p></div>);
          })}
        </div>
        {importPhase === 0 && (<div className="space-y-3">
          <div className="rounded-2xl overflow-hidden" style={{boxShadow:'0 4px 20px rgba(0,0,0,0.3)',border:'1px solid rgba(251,191,36,0.15)'}}>
            <div className="px-4 py-2.5" style={{background:'linear-gradient(135deg,#FBBF24,#F59E0B)'}}><p style={{fontSize:14,fontWeight:800,color:'#1a1a1a',margin:0}}>Step 1: ดาวน์โหลด Template Excel</p></div>
            <div className="p-4">
              <p className="text-[13px] text-neutral-400 mb-3">กรอกแค่ที่มี — ข้อมูลไม่ครบระบบถามเพิ่มทีหลัง</p>
              {[{sheet:'Sheet 1: ข้อมูลรถ',req:'ทะเบียน ★, จังหวัด ★, ประเภทรถ ★',opt:'ยี่ห้อ, รุ่น, ล้อ, น้ำหนัก, พ.ร.บ., ประกัน',icon:'car',cl:'#60A5FA',example:'8 คันตัวอย่าง'},
                {sheet:'Sheet 2: ข้อมูลผู้ขับรถ',req:'ชื่อ-นามสกุล ★, เบอร์โทร ★',opt:'ใบขับขี่, วุฒิบัตร, วันหมดอายุ, รถที่รับผิดชอบ',icon:'users',cl:'#FBBF24',example:'6 คนตัวอย่าง'}
              ].map((s,i) => (
                <div key={i} className="rounded-xl p-3 mb-2 flex items-start gap-3" style={{background:'rgba(255,255,255,0.02)',border:'1px solid rgba(255,255,255,0.04)',boxShadow:'0 2px 8px rgba(0,0,0,0.15)'}}>
                  <div className="w-8 h-8 rounded-xl flex items-center justify-center shrink-0 mt-0.5" style={{background:s.cl+'15'}}><Icon type={s.icon} className="h-3.5 w-3.5" style={{color:s.cl}}/></div>
                  <div className="flex-1"><p className="text-sm text-white font-medium">{s.sheet} <span className="text-[13px] text-neutral-500">({s.example})</span></p><p className="text-[13px] mt-1"><span className="text-emerald-400 font-bold">ต้องมี:</span> <span className="text-neutral-400">{s.req}</span></p><p className="text-[13px]"><span className="text-neutral-600">เสริม:</span> <span className="text-neutral-500">{s.opt}</span></p></div>
                </div>
              ))}
              <button onClick={() => { const a = document.createElement('a'); a.href = '/mnt/user-data/outputs/TSMC_Import_Template.xlsx'; a.download = 'TSMC_Import_Template.xlsx'; a.click(); }} className="w-full h-11 rounded-xl text-sm font-bold cursor-pointer flex items-center justify-center gap-2 mt-2" style={{background:'linear-gradient(135deg,#FBBF24,#F59E0B)',color:'#1a1a1a'}}><Icon type="file" className="h-4 w-4" style={{color:'#1a1a1a'}}/> ดาวน์โหลด Template (.xlsx)</button>
            </div>
          </div>
          <div className="rounded-2xl overflow-hidden" style={{boxShadow:'0 4px 20px rgba(0,0,0,0.3)',border:'1px solid rgba(255,255,255,0.06)'}}>
            <div className="px-4 py-2.5" style={{background:'linear-gradient(135deg,#FBBF24,#F59E0B)'}}><p style={{fontSize:14,fontWeight:800,color:'#1a1a1a',margin:0}}>Step 2: อัปโหลดไฟล์</p></div>
            <div className="p-4">
              <div className="rounded-2xl border-2 border-dashed p-6 text-center cursor-pointer transition-all duration-200" style={{borderColor:'rgba(255,255,255,0.1)',background:'rgba(255,255,255,0.01)'}} onClick={() => { setImportPhase(1); }} onMouseEnter={e=>{e.currentTarget.style.borderColor='rgba(251,191,36,0.3)';e.currentTarget.style.background='rgba(251,191,36,0.02)';}} onMouseLeave={e=>{e.currentTarget.style.borderColor='rgba(255,255,255,0.1)';e.currentTarget.style.background='rgba(255,255,255,0.01)';}}>
                <div className="w-14 h-14 rounded-2xl flex items-center justify-center mx-auto mb-3" style={{background:'rgba(251,191,36,0.1)'}}><Icon type="file" className="h-6 w-6 text-yellow-400"/></div>
                <p className="text-base text-white font-medium mb-1">ลากไฟล์มาวาง หรือกดเลือกไฟล์</p>
                <p className="text-[13px] text-neutral-500 mb-3">รองรับ .xlsx, .xls, .csv • ไฟล์เดียวมีทั้งรถ+ผู้ขับ</p>
              </div>
              <div className="rounded-xl p-3 mt-3" style={{background:'rgba(96,165,250,0.05)',border:'1px solid rgba(96,165,250,0.1)'}}>
                <p className="text-[13px] text-neutral-400 font-bold mb-2">วิธีอัพโหลด</p>
                {[
                  {n:'1',t:'ดาวน์โหลด Template ด้านบน',cl:'#FBBF24'},
                  {n:'2',t:'เปิดใน Excel/Google Sheets แล้วกรอกข้อมูลรถ + ผู้ขับ',cl:'#60A5FA'},
                  {n:'3',t:'Save เป็น .xlsx แล้วลากมาวางตรงนี้',cl:'#34D399'},
                  {n:'4',t:'ระบบประมวลผล ลบซ้ำ ทำความสะอาดให้อัตโนมัติ',cl:'#A78BFA'},
                ].map((s,i) => (
                  <div key={i} className="flex items-center gap-2 py-1.5">
                    <div className="w-5 h-5 rounded-md flex items-center justify-center shrink-0" style={{background:s.cl+'15'}}><span className="text-[13px] font-bold" style={{color:s.cl}}>{s.n}</span></div>
                    <p className="text-[13px] text-neutral-400">{s.t}</p>
                  </div>
                ))}
              </div>
            </div>
          </div>
        </div>)}
        {importPhase === 1 && (<div className="rounded-2xl overflow-hidden" style={{boxShadow:'0 4px 20px rgba(0,0,0,0.3)',border:'1px solid rgba(251,191,36,0.15)'}}>
          <div className="px-4 py-2.5" style={{background:'linear-gradient(135deg,#FBBF24,#F59E0B)'}}><p style={{fontSize:14,fontWeight:800,color:'#1a1a1a',margin:0}}>กำลังประมวลผล...</p></div>
          <div className="p-6">
            <div className="w-16 h-16 rounded-2xl mx-auto mb-4 flex items-center justify-center" style={{background:'rgba(251,191,36,0.1)',border:'2px solid #FBBF24'}}><div className="w-8 h-8 rounded-full border-2 border-yellow-400 border-t-transparent" style={{animation:'spin 0.8s linear infinite'}}/></div>
            <style>{`@keyframes spin{to{transform:rotate(360deg)}}@keyframes fadeIn{from{opacity:0;transform:translateX(-8px)}to{opacity:1;transform:translateX(0)}}@keyframes slideUp{from{opacity:0;transform:translateY(8px)}to{opacity:1;transform:translateY(0)}}@keyframes strikethrough{from{width:0}to{width:100%}}`}</style>
            <div className="space-y-3 max-w-sm mx-auto">
              {[
                {step:'อ่านไฟล์ Excel — 2 sheets (รถ + ผู้ขับ)',icon:'file',cl:'#60A5FA',delay:0},
                {step:'พบข้อมูล: รถ 8 คัน + ผู้ขับ 6 คน',icon:'check',cl:'#34D399',delay:0.8},
                {step:'กำลังตรวจข้อมูลซ้ำ...',icon:'shield',cl:'#FBBF24',delay:1.6},
                {step:'พบซ้ำ 2 รายการ → ลบอัตโนมัติ',icon:'incident',cl:'#F87171',delay:2.4},
                {step:'ทำความสะอาด: ลบช่องว่าง, แก้ format',icon:'settings',cl:'#A78BFA',delay:3.2},
                {step:'วิเคราะห์ข้อมูลที่ขาด — พบ 8 ช่อง',icon:'chart',cl:'#FBBF24',delay:4.0},
                {step:'บันทึกเข้าระบบสำเร็จ!',icon:'check',cl:'#34D399',delay:4.8},
              ].map((s,i) => (
                <div key={i} className="flex items-center gap-3 px-3 py-2 rounded-xl" style={{animation:`fadeIn 0.4s ${s.delay}s both`,background:i===3?'rgba(248,113,113,0.05)':i===4?'rgba(167,139,250,0.05)':'transparent'}}>
                  <div className="w-7 h-7 rounded-lg flex items-center justify-center shrink-0" style={{background:s.cl+'15'}}><Icon type={s.icon} className="h-3.5 w-3.5" style={{color:s.cl}}/></div>
                  <p className="text-sm" style={{color:i<=3?'white':'rgba(255,255,255,0.5)'}}>{s.step}</p>
                  {i === 3 && <span className="text-[13px] font-bold px-1.5 py-0.5 rounded ml-auto shrink-0" style={{background:'rgba(248,113,113,0.15)',color:'#F87171',animation:`slideUp 0.3s ${s.delay+0.3}s both`}}>ลบแล้ว</span>}
                  {i === 4 && <span className="text-[13px] font-bold px-1.5 py-0.5 rounded ml-auto shrink-0" style={{background:'rgba(167,139,250,0.15)',color:'#A78BFA',animation:`slideUp 0.3s ${s.delay+0.3}s both`}}>สะอาด</span>}
                </div>
              ))}
            </div>
            <div className="h-2 rounded-full bg-neutral-800 overflow-hidden mt-4 max-w-sm mx-auto">
              <div className="h-full rounded-full" style={{background:'linear-gradient(90deg,#FBBF24,#34D399)',animation:'progress 5s ease-out forwards',width:0}}/>
              <style>{`@keyframes progress{0%{width:0}20%{width:20%}40%{width:40%}60%{width:65%}80%{width:85%}100%{width:100%}}`}</style>
            </div>
            <p className="text-[13px] text-neutral-500 text-center mt-3" style={{animation:'fadeIn 0.5s 5s both'}}>เสร็จแล้ว — กดถัดไปเพื่อดูผลลัพธ์</p>
            <div className="text-center mt-3" style={{animation:'fadeIn 0.3s 5.5s both'}}>
              <button onClick={() => { setImportPhase(2); setDupCount(2); }} className="px-6 py-2.5 rounded-xl text-sm font-bold cursor-pointer" style={{background:'linear-gradient(135deg,#FBBF24,#F59E0B)',color:'#1a1a1a'}}>ดูผลลัพธ์ →</button>
            </div>
          </div>
        </div>)}
        {importPhase === 2 && fillPhase === null && (<div className="space-y-3">
          <div className="rounded-2xl overflow-hidden" style={{boxShadow:'0 4px 20px rgba(0,0,0,0.3)',border:'1px solid rgba(52,211,153,0.2)'}}>
            <div className="px-4 py-2.5" style={{background:'linear-gradient(135deg,#FBBF24,#F59E0B)'}}><p style={{fontSize:14,fontWeight:800,color:'#1a1a1a',margin:0}}>นำเข้าสำเร็จ!</p></div>
            <div className="p-4">
              <div className="grid grid-cols-4 gap-2 mb-3">
                {[{l:'รถ',v:'8',s:'คัน',cl:'#60A5FA'},{l:'ผู้ใช้',v:'9',s:'คน',cl:'#FBBF24'},{l:'จับคู่',v:'5',s:'คู่',cl:'#34D399'},{l:'ซ้ำ',v:dupCount+'',s:'ลบแล้ว',cl:'#F87171'}].map((s,i) => (
                  <div key={i} className="rounded-xl p-2.5 text-center" style={{background:s.cl+'08',border:'1px solid '+s.cl+'15'}}><p className="text-lg font-black" style={{color:s.cl}}>{s.v}</p><p className="text-[13px] text-neutral-500">{s.l}</p></div>
                ))}
              </div>
              <div className="rounded-xl p-3 flex items-center gap-2" style={{background:'rgba(52,211,153,0.05)',border:'1px solid rgba(52,211,153,0.1)'}}><span className="text-base">✅</span><p className="text-[13px] text-neutral-400">นำเข้า <span className="text-emerald-400 font-bold">17 รายการ</span> สำเร็จ ลบซ้ำ {dupCount} อัตโนมัติ</p></div>
            </div>
          </div>
          {totalGaps > 0 && (<div className="rounded-2xl overflow-hidden" style={{boxShadow:'0 4px 20px rgba(0,0,0,0.3)',border:'1px solid rgba(251,191,36,0.15)'}}>
            <div className="px-4 py-2.5 flex items-center justify-between" style={{background:'linear-gradient(135deg,#FBBF24,#F59E0B)'}}><p style={{fontSize:14,fontWeight:800,color:'#1a1a1a',margin:0}}>ข้อมูลที่ยังไม่ครบ</p><span style={{fontSize:13,fontWeight:700,color:'rgba(0,0,0,0.4)'}}>{totalGaps} ช่อง</span></div>
            <div className="p-3">
              {gapFields.map((g,i) => (<div key={'v'+i} className="flex items-center gap-3 px-2 py-2.5 rounded-xl" style={{borderBottom:'1px solid rgba(255,255,255,0.03)'}}><div className="w-8 h-8 rounded-xl flex items-center justify-center shrink-0" style={{background:'rgba(96,165,250,0.15)'}}><Icon type="car" className="h-3.5 w-3.5 text-sky-400"/></div><span className="text-sm text-white font-medium flex-1">{g.vehicle}</span><div className="flex gap-1 flex-wrap justify-end">{g.missing.map((m,j) => <span key={j} className="text-[13px] px-1.5 py-0.5 rounded" style={{background:'rgba(251,191,36,0.1)',color:'#FBBF24'}}>{m}</span>)}</div></div>))}
              {gapDrivers.map((g,i) => (<div key={'d'+i} className="flex items-center gap-3 px-2 py-2.5 rounded-xl" style={{borderBottom:i<gapDrivers.length-1?'1px solid rgba(255,255,255,0.03)':'none'}}><div className="w-8 h-8 rounded-xl flex items-center justify-center shrink-0" style={{background:'rgba(251,191,36,0.15)'}}><Icon type="users" className="h-3.5 w-3.5 text-yellow-400"/></div><span className="text-sm text-white font-medium flex-1">{g.driver}</span><div className="flex gap-1 flex-wrap justify-end">{g.missing.map((m,j) => <span key={j} className="text-[13px] px-1.5 py-0.5 rounded" style={{background:'rgba(251,191,36,0.1)',color:'#FBBF24'}}>{m}</span>)}</div></div>))}
              <div className="flex gap-2 mt-3">
                <button onClick={() => setFillPhase('filling')} className="flex-1 h-11 rounded-xl text-sm font-bold cursor-pointer" style={{background:'linear-gradient(135deg,#FBBF24,#F59E0B)',color:'#1a1a1a'}}>เสริมข้อมูล ({totalGaps} ช่อง)</button>
                <button onClick={() => { if(setSetupStep && setupStep < 2) setSetupStep(2); setSubPage('driver_vehicle'); }} className="flex-1 h-11 rounded-xl text-sm font-medium cursor-pointer" style={{background:'rgba(255,255,255,0.04)',border:'1px solid rgba(255,255,255,0.08)',color:'rgba(255,255,255,0.5)'}}>ข้ามไปก่อน →</button>
              </div>
            </div>
          </div>)}
          {totalGaps === 0 && (<button onClick={() => { if(setSetupStep && setupStep < 2) setSetupStep(2); setSubPage('driver_vehicle'); }} className="w-full h-11 rounded-xl font-bold text-sm cursor-pointer" style={{background:'linear-gradient(135deg,#FBBF24,#F59E0B)',color:'#1a1a1a'}}>ผูกผู้ประจำรถ →</button>)}
        </div>)}
        {fillPhase === 'filling' && (() => {
          const allGaps = [...gapFields.flatMap(g => g.missing.map(m => ({entity:g.vehicle,field:m,type:'vehicle'}))), ...gapDrivers.flatMap(g => g.missing.map(m => ({entity:g.driver,field:m,type:'driver'})))];
          const current = allGaps[fillIdx];
          if (!current) return (<div className="rounded-2xl overflow-hidden text-center" style={{boxShadow:'0 4px 20px rgba(0,0,0,0.3)'}}><div className="p-6" style={{background:'linear-gradient(135deg,#FBBF24,#F59E0B)'}}><div className="text-4xl mb-3">🎉</div><p style={{fontSize:20,fontWeight:800,color:'#1a1a1a',margin:0}}>ข้อมูลครบ 100%!</p><p style={{fontSize:13,color:'rgba(0,0,0,0.5)',marginTop:4}}>ครั้งต่อไปทำฟอร์ม ระบบจะไม่ถามซ้ำอีก</p></div><div className="p-4"><button onClick={() => { if(setSetupStep && setupStep < 2) setSetupStep(2); setSubPage('driver_vehicle'); }} className="px-6 py-2.5 rounded-xl font-bold cursor-pointer" style={{background:'linear-gradient(135deg,#FBBF24,#F59E0B)',color:'#1a1a1a'}}>ผูกผู้ประจำรถ →</button></div></div>);
          const gapOpts = {'น้ำหนักบรรทุกสูงสุด':['4,000 kg','6,000 kg','8,000 kg','12,000 kg','15,000 kg'],'วันหมด พ.ร.บ.':['30 มิ.ย. 2569','31 ธ.ค. 2569','30 มิ.ย. 2570','31 ธ.ค. 2570'],'ชื่อผู้ขับประจำ':['ประเสริฐ','สุรชัย','อนันต์','วิชัย','สมศักดิ์','ธนา'],'ประเภทเชื้อเพลิง':['ดีเซล','เบนซิน','NGV','ไฟฟ้า'],'เลขใบขับขี่':['ชนิด 2 (ส่วนบุคคล)','ชนิด 3 (สาธารณะ)','ชนิด 4 (ตลอดชีพ)'],'วันหมดอายุใบขับขี่':['30 มิ.ย. 2569','31 ธ.ค. 2569','30 มิ.ย. 2570','31 ธ.ค. 2570'],'เบอร์ติดต่อฉุกเฉิน':['ใส่ภายหลัง','ใช้เบอร์เดียวกับผู้ขับ']};
          return (<div className="rounded-2xl overflow-hidden" style={{boxShadow:'0 4px 20px rgba(0,0,0,0.3)',border:'1px solid rgba(255,255,255,0.06)'}}>
            <div className="px-4 py-2.5 flex items-center justify-between" style={{background:'linear-gradient(135deg,#FBBF24,#F59E0B)'}}><p style={{fontSize:14,fontWeight:800,color:'#1a1a1a',margin:0}}>เสริมข้อมูล {fillIdx+1}/{allGaps.length}</p><button onClick={() => setFillIdx(prev => prev+1)} style={{fontSize:13,fontWeight:700,color:'rgba(0,0,0,0.4)',cursor:'pointer',background:'none',border:'none'}}>ข้าม →</button></div>
            <div className="p-4">
              <div className="h-2 rounded-full bg-neutral-800 overflow-hidden mb-4"><div className="h-full rounded-full transition-all duration-300" style={{width:`${((fillIdx+1)/allGaps.length)*100}%`,background:'linear-gradient(90deg,#FBBF24,#34D399)'}}/></div>
              <div className="rounded-xl p-4 mb-4 flex items-center gap-3" style={{background:current.type==='vehicle'?'rgba(96,165,250,0.05)':'rgba(251,191,36,0.05)',border:'1px solid '+(current.type==='vehicle'?'rgba(96,165,250,0.1)':'rgba(251,191,36,0.1)')}}>
                <div className="w-10 h-10 rounded-xl flex items-center justify-center shrink-0" style={{background:current.type==='vehicle'?'rgba(96,165,250,0.15)':'rgba(251,191,36,0.15)'}}><Icon type={current.type==='vehicle'?'car':'users'} className="h-4 w-4" style={{color:current.type==='vehicle'?'#60A5FA':'#FBBF24'}}/></div>
                <div><p className="text-[13px] text-neutral-500">{current.type==='vehicle'?'รถ':'ผู้ใช้'}: <span className="text-white font-bold">{current.entity}</span></p><p className="text-base text-white font-bold">{current.field}</p></div>
              </div>
              <div className="space-y-2">{(gapOpts[current.field] || ['ระบุทีหลัง']).map((opt,i) => (
                <button key={i} onClick={() => setFillIdx(prev => prev+1)} className="w-full text-left rounded-xl p-3.5 text-sm font-medium cursor-pointer transition-all duration-150" style={{border:'1px solid rgba(255,255,255,0.06)',background:'rgba(255,255,255,0.02)',color:'white'}} onMouseEnter={e=>{e.currentTarget.style.borderColor='rgba(251,191,36,0.3)';e.currentTarget.style.background='rgba(251,191,36,0.05)';e.currentTarget.style.paddingLeft='20px';}} onMouseLeave={e=>{e.currentTarget.style.borderColor='rgba(255,255,255,0.06)';e.currentTarget.style.background='rgba(255,255,255,0.02)';e.currentTarget.style.paddingLeft='14px';}}>{opt}</button>
              ))}</div>
            </div>
          </div>);
        })()}
      </div>
    );
  }

  // ═══ Driver-Vehicle matching
  if (subPage === 'driver_vehicle') {
    const drivers = [{n:'ประเสริฐ',phone:'081-111-1111'},{n:'สุรชัย',phone:'081-222-2222'},{n:'อนันต์',phone:'081-333-3333'},{n:'วิชัย',phone:'081-444-4444'},{n:'สมศักดิ์',phone:'081-555-5555'},{n:'ธนา',phone:'081-666-6666'}];
    const vehicles = [{v:'กน-1658',type:'6 ล้อ HINO'},{v:'1กฐ-6852',type:'10 ล้อ ISUZU'},{v:'บท-3091',type:'6 ล้อ HINO'},{v:'ผก-2244',type:'6 ล้อ HINO'},{v:'2กจ-8103',type:'10 ล้อ ISUZU'},{v:'81-9930',type:'18 ล้อ VOLVO'},{v:'80-4517',type:'18 ล้อ VOLVO'},{v:'บบ-7765',type:'6 ล้อ HINO'}];
    const matched = [{d:'ประเสริฐ',v:'กน-1658'},{d:'สุรชัย',v:'1กฐ-6852'},{d:'อนันต์',v:'บท-3091'},{d:'วิชัย',v:'ผก-2244'},{d:'สมศักดิ์',v:'2กจ-8103'},{d:'ธนา',v:'81-9930'}];
    const unmatched = [{v:'80-4517',type:'18 ล้อ VOLVO'},{v:'บบ-7765',type:'6 ล้อ HINO'}];
    return (
      <div>
        <BackBtn label="กลับจัดการข้อมูล" />
        <style>{`@keyframes matchFadeIn{from{opacity:0;transform:translateY(12px)}to{opacity:1;transform:translateY(0)}}@keyframes matchLine{from{width:0}to{width:100%}}@keyframes matchPulse{0%,100%{box-shadow:0 0 0 0 rgba(52,211,153,0.3)}50%{box-shadow:0 0 0 8px rgba(52,211,153,0)}}@keyframes matchSpin{to{transform:rotate(360deg)}}@keyframes matchCheck{from{transform:scale(0)}to{transform:scale(1)}}`}</style>

        {matchPhase === 0 && (
          <div className="space-y-3">
            <div className="rounded-2xl overflow-hidden" style={{boxShadow:'0 4px 20px rgba(0,0,0,0.3)',border:'1px solid rgba(251,191,36,0.15)'}}>
              <div className="px-4 py-2.5" style={{background:'linear-gradient(135deg,#FBBF24,#F59E0B)'}}>
                <p style={{fontSize:14,fontWeight:800,color:'#1a1a1a',margin:0}}>ผูกผู้ประจำรถ</p>
              </div>
              <div className="p-4">
                <div className="flex gap-4 mb-4">
                  <div className="flex-1 rounded-xl p-3 text-center" style={{background:'rgba(251,191,36,0.06)',border:'1px solid rgba(251,191,36,0.1)'}}>
                    <Icon type="users" className="h-5 w-5 text-yellow-400 mx-auto mb-1"/>
                    <p className="text-2xl font-black text-yellow-400">{drivers.length}</p>
                    <p className="text-[13px] text-neutral-500">ผู้ขับรถ</p>
                  </div>
                  <div className="flex items-center"><Icon type="arrowRight" className="h-5 w-5 text-neutral-600"/></div>
                  <div className="flex-1 rounded-xl p-3 text-center" style={{background:'rgba(96,165,250,0.06)',border:'1px solid rgba(96,165,250,0.1)'}}>
                    <Icon type="car" className="h-5 w-5 text-sky-400 mx-auto mb-1"/>
                    <p className="text-2xl font-black text-sky-400">{vehicles.length}</p>
                    <p className="text-[13px] text-neutral-500">รถทั้งหมด</p>
                  </div>
                </div>
                <p className="text-[13px] text-neutral-400 text-center mb-4">ระบบจับคู่อัตโนมัติจากข้อมูลที่ Import เข้ามา</p>
                <button onClick={() => { setMatchPhase(1); setTimeout(() => setMatchPhase(2), 4000); }}
                  className="w-full h-12 rounded-xl text-sm font-bold cursor-pointer flex items-center justify-center gap-2" style={{background:'linear-gradient(135deg,#FBBF24,#F59E0B)',color:'#1a1a1a'}}>
                  <Icon type="settings" className="h-4 w-4" style={{color:'#1a1a1a'}}/> เริ่ม Auto Match
                </button>
              </div>
            </div>
          </div>
        )}

        {matchPhase === 1 && (
          <div className="rounded-2xl overflow-hidden" style={{boxShadow:'0 4px 20px rgba(0,0,0,0.3)',border:'1px solid rgba(251,191,36,0.15)'}}>
            <div className="px-4 py-2.5" style={{background:'linear-gradient(135deg,#FBBF24,#F59E0B)'}}>
              <p style={{fontSize:14,fontWeight:800,color:'#1a1a1a',margin:0}}>กำลังจับคู่...</p>
            </div>
            <div className="p-4">
              <div className="w-14 h-14 rounded-2xl mx-auto mb-4 flex items-center justify-center" style={{background:'rgba(251,191,36,0.1)',border:'2px solid #FBBF24'}}>
                <div className="w-7 h-7 rounded-full border-2 border-yellow-400 border-t-transparent" style={{animation:'matchSpin 0.8s linear infinite'}}/>
              </div>
              <div className="space-y-2">
                {matched.map((p,i) => (
                  <div key={i} className="flex items-center gap-2 px-3 py-2.5 rounded-xl" style={{animation:`matchFadeIn 0.4s ${i*0.5}s both`}}>
                    <div className="w-8 h-8 rounded-xl flex items-center justify-center text-[13px] font-bold text-white shrink-0" style={{background:'linear-gradient(135deg,#FBBF24,#F59E0B)'}}>{p.d[0]}</div>
                    <span className="text-sm text-white">{p.d}</span>
                    <div className="flex-1 h-0.5 rounded mx-2 overflow-hidden" style={{background:'rgba(255,255,255,0.06)'}}>
                      <div className="h-full rounded" style={{background:'linear-gradient(90deg,#FBBF24,#34D399)',animation:`matchLine 0.6s ${i*0.5+0.2}s both`}}/>
                    </div>
                    <div className="w-8 h-8 rounded-xl flex items-center justify-center shrink-0" style={{background:'rgba(96,165,250,0.15)'}}>
                      <Icon type="car" className="h-3.5 w-3.5 text-sky-400"/>
                    </div>
                    <span className="text-sm text-sky-400 font-bold">{p.v}</span>
                    <div className="w-5 h-5 rounded-full flex items-center justify-center shrink-0" style={{background:'rgba(52,211,153,0.15)',animation:`matchCheck 0.3s ${i*0.5+0.5}s both`,transform:'scale(0)'}}>
                      <span className="text-emerald-400 text-[13px]">✓</span>
                    </div>
                  </div>
                ))}
              </div>
              <div className="h-2 rounded-full bg-neutral-800 overflow-hidden mt-4">
                <div className="h-full rounded-full" style={{background:'linear-gradient(90deg,#FBBF24,#34D399)',animation:'matchLine 3.5s ease-out forwards'}}/>
              </div>
            </div>
          </div>
        )}

        {matchPhase === 2 && (
          <div className="space-y-3">
            <div className="rounded-2xl overflow-hidden" style={{boxShadow:'0 4px 20px rgba(0,0,0,0.3)',border:'1px solid rgba(52,211,153,0.15)'}}>
              <div className="px-4 py-2.5 flex items-center justify-between" style={{background:'linear-gradient(135deg,#FBBF24,#F59E0B)'}}>
                <p style={{fontSize:14,fontWeight:800,color:'#1a1a1a',margin:0}}>จับคู่สำเร็จ!</p>
                <span style={{fontSize:13,fontWeight:700,color:'rgba(0,0,0,0.4)'}}>{matched.length}/{drivers.length} คู่</span>
              </div>
              <div className="p-3">
                {matched.map((p,i) => (
                  <div key={i} className="flex items-center gap-3 px-3 py-2.5 rounded-xl" style={{borderBottom:i<matched.length-1?'1px solid rgba(255,255,255,0.03)':'none',animation:`matchFadeIn 0.3s ${i*0.1}s both`}}>
                    <div className="w-8 h-8 rounded-xl flex items-center justify-center text-[13px] font-bold text-white shrink-0" style={{background:'linear-gradient(135deg,#FBBF24,#F59E0B)',animation:'matchPulse 2s ease-in-out infinite'}}>{p.d[0]}</div>
                    <span className="text-sm text-white flex-1">{p.d}</span>
                    <div className="px-2"><Icon type="arrowRight" className="h-3 w-3 text-emerald-400"/></div>
                    <div className="w-8 h-8 rounded-xl flex items-center justify-center shrink-0" style={{background:'rgba(96,165,250,0.15)'}}><Icon type="car" className="h-3.5 w-3.5 text-sky-400"/></div>
                    <span className="text-sm text-sky-400 font-bold">{p.v}</span>
                    <span className="text-[13px] font-bold px-1.5 py-0.5 rounded-lg" style={{background:'rgba(52,211,153,0.15)',color:'#34D399'}}>จับคู่แล้ว</span>
                  </div>
                ))}
              </div>
            </div>

            {unmatched.length > 0 && (
              <div className="rounded-2xl overflow-hidden" style={{boxShadow:'0 4px 16px rgba(0,0,0,0.2)',border:'1px solid rgba(251,191,36,0.15)'}}>
                <div className="px-4 py-2.5" style={{background:'linear-gradient(135deg,#FBBF24,#F59E0B)'}}>
                  <p style={{fontSize:14,fontWeight:800,color:'#1a1a1a',margin:0}}>รถที่ยังไม่มีผู้ขับ ({unmatched.length} คัน)</p>
                </div>
                <div className="p-3">
                  {unmatched.map((u,i) => (
                    <div key={i} className="flex items-center gap-3 px-3 py-2.5 rounded-xl" style={{borderBottom:i<unmatched.length-1?'1px solid rgba(255,255,255,0.03)':'none'}}>
                      <div className="w-8 h-8 rounded-xl flex items-center justify-center shrink-0" style={{background:'rgba(251,191,36,0.15)'}}><Icon type="car" className="h-3.5 w-3.5 text-yellow-400"/></div>
                      <div className="flex-1"><p className="text-sm text-white">{u.v}</p><p className="text-[13px] text-neutral-500">{u.type}</p></div>
                      <span className="text-[13px] font-bold px-2 py-0.5 rounded-lg" style={{background:'rgba(251,191,36,0.15)',color:'#FBBF24'}}>ว่าง</span>
                    </div>
                  ))}
                  <p className="text-[13px] text-neutral-500 mt-2 px-2">จับคู่ทีหลังได้จากหน้านี้</p>
                </div>
              </div>
            )}

            <button onClick={() => { if(setSetupStep && setupStep < 3) setSetupStep(3); setSubPage('form_toggle'); }}
              className="w-full h-12 rounded-xl text-sm font-bold cursor-pointer flex items-center justify-center gap-2" style={{background:'linear-gradient(135deg,#FBBF24,#F59E0B)',color:'#1a1a1a'}}>
              เปิดแบบฟอร์ม →
            </button>
          </div>
        )}
      </div>
    );
  }

  // ═══ Form Toggle
  if (subPage === 'form_toggle') {
    return <FormToggleView onDone={() => { if(setSetupStep && setupStep < 4) setSetupStep(4); setSubPage(null); }} />;
  }

  // ═══ Profile
  // ═══ Company sub-page
  if (subPage === 'company') {
    return (
      <div>
        <BackBtn label="กลับจัดการข้อมูล" />
        <h3 className="text-base font-bold text-white mb-4">ข้อมูลบริษัท</h3>
        <div className="rounded-2xl p-4 space-y-3" style={{border:'1px solid rgba(255,255,255,0.06)'}}>
          {[{l:'ชื่อบริษัท',v:'บริษัท ขนส่งปลอดภัย จำกัด'},{l:'เลขนิติบุคคล',v:'0105564012345'},{l:'ที่อยู่',v:'123/4 ถ.มิตรภาพ ต.ในเมือง อ.เมือง จ.ขอนแก่น 40000'},{l:'เลข TSM',v:'TSM-2569-001234'},{l:'ประเภทขนส่ง',v:'ไม่ประจำทาง — สินค้าทั่วไป'},{l:'ใบอนุญาตหมดอายุ',v:'31 ธ.ค. 2570'}].map((f,i) => (
            <div key={i} className="flex items-start gap-3 py-2" style={{borderBottom:i<5?'1px solid rgba(255,255,255,0.04)':'none'}}>
              <span className="text-sm text-neutral-500 w-32 shrink-0">{f.l}</span>
              <span className="text-sm text-white font-medium">{f.v}</span>
            </div>
          ))}
        </div>
      </div>
    );
  }

  // ═══ Vehicles sub-page — large dataset ready
  if (subPage === 'vehicles') {
    const allVehicles = [
      {reg:'กน-1658 กรุงเทพ',type:'6 ล้อ',brand:'HINO 500',driver:'ประเสริฐ',status:'พร้อมใช้',km:'45,230',sc:'#34D399'},
      {reg:'1กฐ-6852 ขอนแก่น',type:'10 ล้อ',brand:'ISUZU FTR',driver:'สุรชัย',status:'พร้อมใช้',km:'38,100',sc:'#34D399'},
      {reg:'บท-3091 นครราชสีมา',type:'6 ล้อ',brand:'HINO 300',driver:'อนันต์',status:'พร้อมใช้',km:'52,400',sc:'#34D399'},
      {reg:'80-4517 ชลบุรี',type:'18 ล้อ',brand:'VOLVO FH',driver:'—',status:'ซ่อมบำรุง',km:'120,500',sc:'#FBBF24'},
      {reg:'ผก-2244 ขอนแก่น',type:'6 ล้อ',brand:'HINO 500',driver:'วิชัย',status:'พร้อมใช้',km:'89,200',sc:'#34D399'},
      {reg:'2กจ-8103 กรุงเทพ',type:'10 ล้อ',brand:'ISUZU GXZ',driver:'สมศักดิ์',status:'พร้อมใช้',km:'67,800',sc:'#34D399'},
      {reg:'บบ-7765 อุดรธานี',type:'6 ล้อ',brand:'HINO 300',driver:'—',status:'หมดอายุ',km:'95,100',sc:'#F87171'},
      {reg:'81-9930 ขอนแก่น',type:'18 ล้อ',brand:'VOLVO FM',driver:'ธนา',status:'พร้อมใช้',km:'110,300',sc:'#34D399'},
    ];
    const filtered = allVehicles.filter(v => {
      if (vFilter === 'ready' && v.status !== 'พร้อมใช้') return false;
      if (vFilter === 'issue' && v.status === 'พร้อมใช้') return false;
      if (vSearch && !v.reg.includes(vSearch) && !v.brand.toLowerCase().includes(vSearch.toLowerCase()) && !v.driver.includes(vSearch)) return false;
      return true;
    });
    return (
      <div>
        <BackBtn label="กลับจัดการข้อมูล" />
        <div className="flex items-center justify-between mb-4">
          <h3 className="text-base font-bold text-white">ข้อมูลรถ ({allVehicles.length} คัน)</h3>
          <div className="flex gap-2">
            {[{k:'all',l:'ทั้งหมด'},{k:'ready',l:'พร้อมใช้'},{k:'issue',l:'ปัญหา'}].map(f=>(
              <button key={f.k} onClick={()=>setVFilter(f.k)}
                className={cn('px-3 py-1 rounded-lg text-[13px] font-medium cursor-pointer transition',
                  vFilter===f.k?'bg-yellow-400 text-neutral-900':'text-neutral-500 bg-white/[0.03]')}>{f.l}</button>
            ))}
          </div>
        </div>
        <input value={vSearch} onChange={e=>setVSearch(e.target.value)}
          className="w-full h-11 rounded-xl border border-white/10 bg-white/[0.03] px-4 text-sm text-white outline-none focus:border-yellow-400 transition mb-3"
          placeholder="ค้นหาทะเบียน / ยี่ห้อ / ผู้ขับ..." />
        <div className="rounded-2xl overflow-hidden" style={{border:'1px solid rgba(255,255,255,0.06)'}}>
          <div style={{height:2,background:'linear-gradient(90deg,#60A5FA,transparent)'}}/>
          {filtered.map((v,i) => (
            <div key={i} className="flex items-center gap-3 px-4 py-3 cursor-pointer transition-all duration-150"
              style={{borderBottom:i<filtered.length-1?'1px solid rgba(255,255,255,0.04)':'none'}}
              onMouseEnter={e=>{e.currentTarget.style.background='rgba(255,255,255,0.02)';}}
              onMouseLeave={e=>{e.currentTarget.style.background='';}}>
              <div className="w-9 h-9 rounded-xl flex items-center justify-center shrink-0" style={{background:'rgba(96,165,250,0.1)'}}><Icon type="car" className="h-4 w-4 text-sky-400"/></div>
              <div className="flex-1 min-w-0">
                <div className="flex items-center gap-2">
                  <p className="text-sm text-white font-bold">{v.reg}</p>
                  <span className="text-[13px] text-neutral-500">{v.type} • {v.brand}</span>
                </div>
                <p className="text-[13px] text-neutral-500">ผู้ขับ: {v.driver} • {v.km} km</p>
              </div>
              <span className="text-[13px] font-bold px-2 py-0.5 rounded-md shrink-0" style={{background:v.sc+'15',color:v.sc}}>{v.status}</span>
            </div>
          ))}
          {filtered.length === 0 && <p className="text-sm text-neutral-500 text-center py-6">ไม่พบข้อมูลรถ</p>}
        </div>
        <p className="text-[13px] text-neutral-600 mt-3 text-center">แสดง {filtered.length}/{allVehicles.length} คัน • รองรับ 100+ คัน ผ่าน Import Excel</p>
      </div>
    );
  }

  // ═══ Users sub-page — large dataset ready
  if (subPage === 'users') {
    const allUsers = [
      {n:'ประเสริฐ รถมั่นคง',role:'ผู้ขับรถ',vehicle:'กน-1658',phone:'081-111-1111',status:'ปฏิบัติงาน',sc:'#34D399',cert:'ขับรถปลอดภัย',certSt:'หมดแล้ว!',certCl:'#F87171'},
      {n:'สุรชัย ขับดี',role:'ผู้ขับรถ',vehicle:'1กฐ-6852',phone:'081-222-2222',status:'ปฏิบัติงาน',sc:'#34D399',cert:'ขับรถปลอดภัย',certSt:'อีก 92 วัน',certCl:'#FBBF24'},
      {n:'อนันต์ ปลอดภัย',role:'ผู้ขับรถ',vehicle:'บท-3091',phone:'081-333-3333',status:'ปฏิบัติงาน',sc:'#34D399',cert:'สินค้าอันตราย',certSt:'อีก 138 วัน',certCl:'#34D399'},
      {n:'วิชัย ส่งด่วน',role:'ผู้ขับรถ',vehicle:'ผก-2244',phone:'081-444-4444',status:'ปฏิบัติงาน',sc:'#34D399',cert:'ยังไม่ผ่านอบรม',certSt:'ต้องอบรม',certCl:'#F87171'},
      {n:'สมศักดิ์ ถนนดี',role:'ผู้ขับรถ',vehicle:'2กจ-8103',phone:'081-555-5555',status:'ปฏิบัติงาน',sc:'#34D399',cert:'ขับรถปลอดภัย',certSt:'อีก 185 วัน',certCl:'#34D399'},
      {n:'ธนา เดินทาง',role:'ผู้ขับรถ',vehicle:'81-9930',phone:'081-666-6666',status:'วันหยุด',sc:'#FBBF24',cert:'ขับรถปลอดภัย',certSt:'อีก 260 วัน',certCl:'#34D399'},
      {n:'สุภาพร ร่วมงาน',role:'เจ้าหน้าที่',vehicle:'—',phone:'081-777-7777',status:'ปฏิบัติงาน',sc:'#34D399',cert:'—',certSt:'ไม่มี',certCl:'#6B7280'},
      {n:'สมชาย ใจดี',role:'TSM',vehicle:'—',phone:'081-234-5678',status:'ปฏิบัติงาน',sc:'#34D399',cert:'TSM 18 ชม.',certSt:'อีก 291 วัน',certCl:'#34D399'},
      {n:'นภา บริหาร',role:'เจ้าของกิจการ',vehicle:'—',phone:'081-888-8888',status:'ปฏิบัติงาน',sc:'#34D399',cert:'—',certSt:'ไม่มี',certCl:'#6B7280'},
    ];
    const filtered = allUsers.filter(u => {
      if (uFilter === 'driver' && u.role !== 'ผู้ขับรถ') return false;
      if (uFilter === 'staff' && u.role === 'ผู้ขับรถ') return false;
      if (uSearch && !u.n.includes(uSearch) && !u.phone.includes(uSearch) && !u.vehicle.includes(uSearch)) return false;
      return true;
    });
    return (
      <div>
        <BackBtn label="กลับจัดการข้อมูล" />
        <div className="flex items-center justify-between mb-4">
          <h3 className="text-base font-bold text-white">ผู้ใช้ทั้งหมด ({allUsers.length} คน)</h3>
          <div className="flex gap-2">
            {[{k:'all',l:'ทั้งหมด'},{k:'driver',l:'ผู้ขับ'},{k:'staff',l:'เจ้าหน้าที่'}].map(f=>(
              <button key={f.k} onClick={()=>setUFilter(f.k)}
                className={cn('px-3 py-1 rounded-lg text-[13px] font-medium cursor-pointer transition',
                  uFilter===f.k?'bg-yellow-400 text-neutral-900':'text-neutral-500 bg-white/[0.03]')}>{f.l}</button>
            ))}
          </div>
        </div>
        <input value={uSearch} onChange={e=>setUSearch(e.target.value)}
          className="w-full h-11 rounded-xl border border-white/10 bg-white/[0.03] px-4 text-sm text-white outline-none focus:border-yellow-400 transition mb-3"
          placeholder="ค้นหาชื่อ / เบอร์โทร / ทะเบียนรถ..." />
        <div className="rounded-2xl overflow-hidden" style={{border:'1px solid rgba(255,255,255,0.06)'}}>
          <div style={{height:2,background:'linear-gradient(90deg,#FBBF24,transparent)'}}/>
          {filtered.map((u,i) => (
            <div key={i} className="flex items-center gap-3 px-4 py-3 cursor-pointer transition-all duration-150"
              style={{borderBottom:i<filtered.length-1?'1px solid rgba(255,255,255,0.04)':'none'}}
              onMouseEnter={e=>{e.currentTarget.style.background='rgba(255,255,255,0.02)';}}
              onMouseLeave={e=>{e.currentTarget.style.background='';}}>
              <div className="w-9 h-9 rounded-xl flex items-center justify-center text-sm font-bold text-white shrink-0" style={{background:'linear-gradient(135deg,#FBBF24,#F59E0B)'}}>{u.n[0]}</div>
              <div className="flex-1 min-w-0">
                <div className="flex items-center gap-2">
                  <p className="text-sm text-white font-medium">{u.n}</p>
                  <span className="text-[13px] px-1.5 py-0.5 rounded text-neutral-400" style={{background:'rgba(255,255,255,0.04)'}}>{u.role}</span>
                </div>
                <p className="text-[13px] text-neutral-500">{u.vehicle !== '—' ? 'รถ '+u.vehicle+' • ' : ''}{u.phone}</p>
                {u.cert !== '—' && <p className="text-[13px] mt-0.5"><span className="text-neutral-600">วุฒิบัตร: </span><span style={{color:u.certCl}} className="font-bold">{u.cert} — {u.certSt}</span></p>}
              </div>
              <div className="text-right shrink-0">
                <span className="text-[13px] font-bold px-2 py-0.5 rounded-md block mb-1" style={{background:u.sc+'15',color:u.sc}}>{u.status}</span>
                {u.certCl === '#F87171' && <span className="text-[13px] font-bold px-2 py-0.5 rounded-md block" style={{background:'rgba(248,113,113,0.15)',color:'#F87171'}}>{u.certSt}</span>}
              </div>
            </div>
          ))}
          {filtered.length === 0 && <p className="text-sm text-neutral-500 text-center py-6">ไม่พบผู้ใช้</p>}
        </div>
        <p className="text-[13px] text-neutral-600 mt-3 text-center">แสดง {filtered.length}/{allUsers.length} คน • รองรับ 100+ คน ผ่าน Import Excel</p>
      </div>
    );
  }

  // ═══ Roles sub-page
  if (subPage === 'roles') {
    return (
      <div>
        <BackBtn label="กลับจัดการข้อมูล" />
        <h3 className="text-base font-bold text-white mb-4">ตำแหน่งและสิทธิ์</h3>
        <div className="space-y-3">
          {[
            {role:'เจ้าหน้าที่ TSM',count:1,menus:8,color:'#FBBF24',perms:['จัดการข้อมูล','จ่ายงาน','ส่งรายงาน','วิเคราะห์']},
            {role:'เจ้าของกิจการ',count:1,menus:5,color:'#60A5FA',perms:['ดูรายงาน','ติดตามงาน','ดูรถ/บุคลากร']},
            {role:'ผู้ขับรถ',count:6,menus:6,color:'#34D399',perms:['ทำฟอร์ม','ดูงาน','ดูรถ/ประวัติ']},
            {role:'เจ้าหน้าที่ทั่วไป',count:1,menus:4,color:'#A78BFA',perms:['ทำฟอร์ม','ดูรายงาน']},
          ].map((r,i) => (
            <div key={i} className="rounded-2xl p-4" style={{border:'1px solid rgba(255,255,255,0.06)',background:'linear-gradient(135deg,rgba(255,255,255,0.02),transparent)'}}>
              <div className="flex items-center justify-between mb-2">
                <div className="flex items-center gap-2">
                  <div className="w-3 h-3 rounded-full" style={{background:r.color}}/>
                  <p className="text-sm text-white font-bold">{r.role}</p>
                </div>
                <span className="text-[13px] text-neutral-500">{r.count} คน • {r.menus} เมนู</span>
              </div>
              <div className="flex flex-wrap gap-1.5">
                {r.perms.map((p,j) => (
                  <span key={j} className="text-[13px] px-2 py-0.5 rounded-md font-medium" style={{background:r.color+'15',color:r.color}}>{p}</span>
                ))}
              </div>
            </div>
          ))}
        </div>
      </div>
    );
  }

    if (subPage === 'profile') {
    return (
      <div>
        <BackBtn label="กลับจัดการข้อมูล" />
        <h3 className="text-base font-bold text-white mb-4">โปรไฟล์ TSM</h3>
        <div className="rounded-xl border border-white/5 bg-white/[0.02] p-4">
          {[{l:'ชื่อ-นามสกุล',v:'สมชาย ใจดี'},{l:'ตำแหน่ง',v:'เจ้าหน้าที่ TSM'},{l:'อีเมล',v:'somchai@transport.co.th'},{l:'เบอร์โทร',v:'081-234-5678'},{l:'บริษัท',v:'บริษัท ขนส่งปลอดภัย จำกัด'},{l:'เลข TSM',v:'TSM-2569-001234'}].map((f,i) => (
            <div key={i} className="flex justify-between py-2 border-b border-white/5 last:border-0">
              <span className="text-[13px] text-neutral-400">{f.l}</span><span className="text-[13px] text-white font-medium">{f.v}</span>
            </div>
          ))}
        </div>
        {setupStep === 0 && setSetupStep && (
          <button onClick={() => { setSetupStep(1); setSubPage(null); }}
            className="w-full h-11 rounded-xl bg-yellow-400 text-neutral-900 font-bold text-sm cursor-pointer mt-4">
            บันทึกโปรไฟล์ → ขั้นตอนถัดไป
          </button>
        )}
      </div>
    );
  }

  // ═══ Main menu grid — categorized
  const categories = [
    {cat:'ข้อมูลตั้งต้น',desc:'ข้อมูลพื้นฐานที่ต้องมีก่อนใช้ระบบ',items:[
      {key:'company',label:'ข้อมูลบริษัท',icon:'building',desc:'ชื่อ ที่อยู่ เลขทะเบียน',status:'ครบ',cl:'#34D399'},
      {key:'vehicles',label:'ข้อมูลรถ',icon:'car',desc:'8 คัน',status:'2 ไม่ครบ',cl:'#FBBF24'},
      {key:'users',label:'ผู้ใช้ทั้งหมด',icon:'users',desc:'9 คน',status:'1 ไม่ครบ',cl:'#FBBF24'},
      {key:'driver_vehicle',label:'ผูกผู้ประจำรถ',icon:'truck',desc:'จับคู่คนขับ → รถ',status:'5/6 คู่',cl:'#FBBF24'},
      {key:'import_data',label:'นำเข้าข้อมูล',icon:'file',desc:'Import Excel/CSV',status:'ล่าสุดเมื่อวาน',cl:'#60A5FA'},
    ]},
    {cat:'การตั้งค่าระบบ',desc:'ปรับแต่งระบบให้เหมาะกับองค์กร',items:[
      {key:'roles',label:'ตำแหน่งและสิทธิ์',icon:'shield',desc:'4 บทบาท',status:'ตั้งค่าแล้ว',cl:'#34D399'},
      {key:'form_toggle',label:'เปิด-ปิดแบบฟอร์ม',icon:'form',desc:'เลือก Tier ที่ใช้',status:'17/17 เปิด',cl:'#34D399'},
      {key:'notif',label:'ตั้งค่าแจ้งเตือน',icon:'bell',desc:'เวลาแจ้งเตือนแต่ละ Tier',status:'ตั้งค่าแล้ว',cl:'#34D399'},
    ]},
    {cat:'โปรไฟล์',desc:'ข้อมูลส่วนตัว TSM',items:[
      {key:'profile',label:'โปรไฟล์ TSM',icon:'users',desc:'ข้อมูลส่วนตัว ลายเซ็น',status:'',cl:'#60A5FA'},
    ]},
  ];

  // Count completeness
  const totalItems = categories.reduce((s,c) => s + c.items.length, 0);
  const completeItems = categories.reduce((s,c) => s + c.items.filter(i => i.cl === '#34D399').length, 0);

  return (
    <div className="space-y-3">
      {/* Overview stats */}
      <div className="grid grid-cols-3 gap-2">
        <div className="rounded-2xl p-3 text-center" style={{border:'1px solid rgba(255,255,255,0.06)',boxShadow:'0 4px 16px rgba(0,0,0,0.2)'}}>
          <p className="text-2xl font-black text-emerald-400">{completeItems}/{totalItems}</p>
          <p className="text-[13px] text-neutral-500">ตั้งค่าครบ</p>
        </div>
        <div className="rounded-2xl p-3 text-center" style={{border:'1px solid rgba(255,255,255,0.06)',boxShadow:'0 4px 16px rgba(0,0,0,0.2)'}}>
          <p className="text-2xl font-black text-sky-400">8</p>
          <p className="text-[13px] text-neutral-500">รถ</p>
        </div>
        <div className="rounded-2xl p-3 text-center" style={{border:'1px solid rgba(255,255,255,0.06)',boxShadow:'0 4px 16px rgba(0,0,0,0.2)'}}>
          <p className="text-2xl font-black text-yellow-400">9</p>
          <p className="text-[13px] text-neutral-500">ผู้ใช้</p>
        </div>
      </div>

      {/* Categorized menu */}
      {categories.map((cat,ci) => (
        <div key={ci} className="rounded-2xl overflow-hidden" style={{boxShadow:'0 4px 20px rgba(0,0,0,0.3)',border:'1px solid rgba(255,255,255,0.06)'}}>
          <div className="px-4 py-2.5 flex items-center justify-between" style={{background:'linear-gradient(135deg,#FBBF24,#F59E0B)'}}>
            <div>
              <p style={{fontSize:14,fontWeight:800,color:'#1a1a1a',margin:0}}>{cat.cat}</p>
              <p style={{fontSize:13,color:'rgba(0,0,0,0.4)',margin:0}}>{cat.desc}</p>
            </div>
            <span style={{fontSize:13,fontWeight:700,color:'rgba(0,0,0,0.3)'}}>{cat.items.length}</span>
          </div>
          <div className="p-2">
            {cat.items.map(s => (
              <button key={s.key} onClick={() => setSubPage(s.key)}
                className="w-full text-left rounded-xl p-3 flex items-center gap-3 cursor-pointer transition-all duration-150"
                style={{borderBottom:'1px solid rgba(255,255,255,0.03)'}}
                onMouseEnter={e=>{e.currentTarget.style.background='rgba(251,191,36,0.04)';e.currentTarget.style.paddingLeft='16px';}}
                onMouseLeave={e=>{e.currentTarget.style.background='transparent';e.currentTarget.style.paddingLeft='12px';}}>
                <div className="w-10 h-10 rounded-xl flex items-center justify-center shrink-0" style={{background:s.cl+'15'}}>
                  <Icon type={s.icon} className="h-4 w-4" style={{color:s.cl}} />
                </div>
                <div className="flex-1 min-w-0">
                  <p className="text-sm font-medium text-white">{s.label}</p>
                  <p className="text-[13px] text-neutral-500">{s.desc}</p>
                </div>
                {s.status && <span className="text-[13px] font-bold px-2 py-0.5 rounded-lg shrink-0" style={{background:s.cl+'15',color:s.cl}}>{s.status}</span>}
                <svg viewBox="0 0 12 12" className="h-3 w-3 text-neutral-600 shrink-0"><path d="M4.5 3l3 3-3 3" fill="none" stroke="currentColor" strokeWidth="1.5" strokeLinecap="round"/></svg>
              </button>
            ))}
          </div>
        </div>
      ))}
    </div>
  );
}

/* ═══════════════════════════════════════════
   FORM TOGGLE VIEW — เปิด-ปิดฟอร์ม 18 ตัว
   ═══════════════════════════════════════════ */
function FormToggleView({ onDone }) {
  const [toggles, setToggles] = useState(() => {
    const t = {}; FORMS.forEach(f => { t[f.id] = true; }); return t;
  });
  const enabled = Object.values(toggles).filter(Boolean).length;

  return (
    <div>
      <div className="flex items-center justify-between mb-4">
        <h3 className="text-base font-bold text-white">เปิด-ปิดแบบฟอร์ม</h3>
        <span className="text-sm text-yellow-400 font-bold">{enabled}/{FORMS.length} เปิดอยู่</span>
      </div>
      {[1,2,3,4,5,0].map(tier => {
        const tf = FORMS.filter(f => f.tier === tier);
        if (!tf.length) return null;
        return (
          <div key={tier} className="mb-3">
            <p className="text-sm font-bold text-yellow-400 mb-1.5">{tier===0?'บริหาร':`Tier ${tier}: ${TIER_NAMES[tier]}`}</p>
            {tf.map(f => (
              <div key={f.id} className="flex items-center justify-between py-2 border-b border-white/5 last:border-0">
                <span className="text-[13px] text-white">{f.name}</span>
                <button onClick={() => setToggles(p => ({...p, [f.id]: !p[f.id]}))}
                  className={cn('w-10 h-5 rounded-full relative cursor-pointer transition-colors', toggles[f.id] ? 'bg-yellow-400' : 'bg-neutral-700')}>
                  <div className={cn('w-4 h-4 rounded-full bg-white absolute top-0.5 transition-all', toggles[f.id] ? 'left-5' : 'left-0.5')} />
                </button>
              </div>
            ))}
          </div>
        );
      })}
      <button onClick={() => { if(onDone) onDone(); }}
        className="w-full h-11 rounded-xl bg-yellow-400 text-neutral-900 font-bold text-sm cursor-pointer mt-3">ยืนยันตั้งค่าฟอร์ม</button>
    </div>
  );
}

/* ═══════════════════════════════════════════
   PROFILE PAGE — จัดการโปรไฟล์
   ═══════════════════════════════════════════ */
function ProfilePage({ role, onBack, userScore }) {
  const profile = roleProfiles[role];
  const [tab, setTab] = useState('info');
  const [editing, setEditing] = useState(false);
  const [saved, setSaved] = useState(false);
  const [form, setForm] = useState({
    name: profile.name,
    email: profile.email,
    phone: profile.phone,
    dept: profile.dept,
  });
  const [pw, setPw] = useState({ old:'', new1:'', new2:'' });
  const [pwSaved, setPwSaved] = useState(false);
  const [notiSettings, setNotiSettings] = useState({
    formRemind: true, dailyReport: true, urgentAlert: true, lineNotif: false, emailNotif: true,
  });

  const handleSave = () => { setEditing(false); setSaved(true); setTimeout(() => setSaved(false), 2000); };
  const handlePwSave = () => { setPwSaved(true); setPw({old:'',new1:'',new2:''}); setTimeout(() => setPwSaved(false), 2000); };

  return (
    <div style={{background:'#080e1c',minHeight:'calc(100vh - 60px)',margin:'-20px -16px -80px',padding:'0 0 80px'}}>

      {/* ═══ Yellow profile banner ═══ */}
      <div style={{background:'linear-gradient(135deg, #FBBF24 0%, #F59E0B 60%, #D97706 100%)',padding:'24px 20px 60px',position:'relative',overflow:'hidden'}}>
        {/* Decorative circles */}
        <div style={{position:'absolute',top:-40,right:-40,width:160,height:160,borderRadius:'50%',background:'rgba(255,255,255,0.1)'}} />
        <div style={{position:'absolute',bottom:-20,left:'30%',width:100,height:100,borderRadius:'50%',background:'rgba(255,255,255,0.08)'}} />

        {/* Back button */}
        <button onClick={onBack} className="flex items-center gap-2 py-2 mb-4 cursor-pointer hover:opacity-80 transition" style={{color:'rgba(0,0,0,0.6)'}}>
          <svg viewBox="0 0 12 12" className="h-4 w-4"><path d="M7.5 2.5l-4 4 4 4" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"/></svg>
          <span className="text-sm font-medium">กลับหน้าหลัก</span>
        </button>

        {/* Profile info on banner */}
        <div className="flex items-center gap-4" style={{position:'relative',zIndex:2}}>
          <div style={{width:72,height:72,borderRadius:20,background:'rgba(0,0,0,0.15)',display:'flex',alignItems:'center',justifyContent:'center',fontSize:28,fontWeight:800,color:'white',border:'3px solid rgba(255,255,255,0.3)',flexShrink:0}}>
            {form.name[0]}
          </div>
          <div style={{flex:1,minWidth:0}}>
            <h1 style={{fontSize:22,fontWeight:800,color:'#1a1a1a',margin:0,lineHeight:1.2}}>{form.name}</h1>
            <p style={{fontSize:14,color:'rgba(0,0,0,0.6)',margin:'2px 0',fontWeight:600}}>{profile.role}</p>
            <p style={{fontSize:13,color:'rgba(0,0,0,0.4)',margin:0}}>{form.dept} • {form.email}</p>
          </div>
          {!editing && tab === 'info' && (
            <button onClick={() => setEditing(true)}
              style={{padding:'8px 16px',borderRadius:12,background:'rgba(0,0,0,0.12)',color:'#1a1a1a',fontSize:13,fontWeight:700,border:'none',cursor:'pointer',flexShrink:0}}>
              แก้ไข
            </button>
          )}
        </div>
        {/* Score badge on banner */}
        <div className="flex gap-2 mt-3" style={{position:'relative',zIndex:2}}>
          <div style={{background:'rgba(0,0,0,0.12)',borderRadius:10,padding:'4px 10px',fontSize:13,fontWeight:700,color:'#1a1a1a'}}>{userScore || 0} คะแนน</div>
          <div style={{background:'rgba(0,0,0,0.08)',borderRadius:10,padding:'4px 10px',fontSize:13,fontWeight:600,color:'rgba(0,0,0,0.6)'}}>{(() => { const lvls = [{min:0,n:'🌱 เริ่มต้น'},{min:50,n:'⭐ มือใหม่'},{min:120,n:'🔥 ชำนาญ'},{min:200,n:'💎 เชี่ยวชาญ'},{min:300,n:'👑 เพชร'}]; return [...lvls].reverse().find(l => (userScore||0) >= l.min)?.n || '🌱 เริ่มต้น'; })()}</div>
        </div>
      </div>

      {/* ═══ Content area pulled up over banner ═══ */}
      <div style={{margin:'-36px 16px 0',position:'relative',zIndex:3}}>

        {/* Tabs */}
        <div className="flex gap-1 p-1 rounded-2xl mb-5" style={{background:'#0d1a2e',border:'1px solid rgba(255,255,255,0.06)'}}>
          {[
            {id:'info', label:'ข้อมูลส่วนตัว', icon:'users'},
            {id:'password', label:'รหัสผ่าน', icon:'lock'},
            {id:'notifications', label:'แจ้งเตือน', icon:'bell'},
            {id:'rewards', label:'คะแนน', icon:'chart'},
            {id:'activity', label:'ประวัติ', icon:'clock'},
          ].map(t => (
            <button key={t.id} onClick={() => { setTab(t.id); setEditing(false); }}
              className={cn('flex-1 py-2.5 rounded-xl text-sm font-bold transition-all cursor-pointer flex items-center justify-center gap-1.5',
                tab === t.id ? 'bg-yellow-400 text-neutral-900 shadow-lg shadow-yellow-400/20' : 'text-neutral-500 hover:text-white')}>
              <Icon type={t.icon} className="h-3.5 w-3.5" />
              <span className="hidden sm:inline">{t.label}</span>
            </button>
          ))}
        </div>

      {saved && (
        <div className="rounded-xl bg-emerald-500/10 border border-emerald-500/20 p-3 mb-4 flex items-center gap-2">
          <Icon type="check" className="h-4 w-4 text-emerald-400" />
          <span className="text-sm text-emerald-400 font-medium">บันทึกเรียบร้อย!</span>
        </div>
      )}

      {pwSaved && (
        <div className="rounded-xl bg-emerald-500/10 border border-emerald-500/20 p-3 mb-4 flex items-center gap-2">
          <Icon type="check" className="h-4 w-4 text-emerald-400" />
          <span className="text-sm text-emerald-400 font-medium">เปลี่ยนรหัสผ่านสำเร็จ!</span>
        </div>
      )}

      {/* ═══ Tab: Info ═══ */}
      {tab === 'info' && (
        <div className="space-y-3">
          {[
            {key:'name', label:'ชื่อ-นามสกุล', icon:'users'},
            {key:'email', label:'อีเมล', icon:'mail'},
            {key:'phone', label:'เบอร์โทร', icon:'phone'},
            {key:'dept', label:'แผนก/ฝ่าย', icon:'building'},
          ].map(f => (
            <div key={f.key} className="rounded-xl border border-white/[0.06] bg-white/[0.02] p-4">
              <div className="flex items-center gap-2 mb-2">
                <Icon type={f.icon} className="h-3.5 w-3.5 text-neutral-500" />
                <label className="text-[13px] text-neutral-500 font-medium">{f.label}</label>
              </div>
              {editing ? (
                <input value={form[f.key]} onChange={e => setForm({...form, [f.key]: e.target.value})}
                  className="h-11 w-full rounded-lg border border-white/10 bg-white/5 px-3 text-base text-white outline-none focus:border-yellow-400 transition" />
              ) : (
                <p className="text-base text-white font-medium">{form[f.key]}</p>
              )}
            </div>
          ))}
          <div className="rounded-xl border border-white/[0.06] bg-white/[0.02] p-4">
            <div className="flex items-center gap-2 mb-2">
              <Icon type="shield" className="h-3.5 w-3.5 text-neutral-500" />
              <label className="text-[13px] text-neutral-500 font-medium">บทบาทในระบบ</label>
            </div>
            <p className="text-base text-yellow-400 font-bold">{profile.role}</p>
          </div>
          {editing && (
            <div className="flex gap-2 mt-2">
              <button onClick={() => setEditing(false)}
                className="flex-1 h-11 rounded-xl border border-white/10 text-neutral-400 text-sm font-medium cursor-pointer hover:bg-white/5 transition">ยกเลิก</button>
              <button onClick={handleSave}
                className="flex-1 h-11 rounded-xl bg-yellow-400 text-neutral-900 text-sm font-bold cursor-pointer hover:bg-yellow-300 transition">บันทึก</button>
            </div>
          )}
        </div>
      )}

      {/* ═══ Tab: Password ═══ */}
      {tab === 'password' && (
        <div className="space-y-3">
          {[
            {key:'old', label:'รหัสผ่านปัจจุบัน', ph:'••••••••'},
            {key:'new1', label:'รหัสผ่านใหม่', ph:'อย่างน้อย 8 ตัวอักษร'},
            {key:'new2', label:'ยืนยันรหัสผ่านใหม่', ph:'พิมพ์อีกครั้ง'},
          ].map(f => (
            <div key={f.key} className="rounded-xl border border-white/[0.06] bg-white/[0.02] p-4">
              <label className="text-[13px] text-neutral-500 font-medium block mb-2">{f.label}</label>
              <input type="password" value={pw[f.key]} onChange={e => setPw({...pw, [f.key]: e.target.value})}
                placeholder={f.ph}
                className="h-11 w-full rounded-lg border border-white/10 bg-white/5 px-3 text-base text-white outline-none placeholder:text-neutral-600 focus:border-yellow-400 transition" />
            </div>
          ))}
          <button onClick={handlePwSave}
            className={cn('w-full h-11 rounded-xl text-sm font-bold cursor-pointer transition',
              pw.new1 && pw.new1 === pw.new2 ? 'bg-yellow-400 text-neutral-900 hover:bg-yellow-300' : 'bg-white/5 text-neutral-600 cursor-not-allowed')}>
            เปลี่ยนรหัสผ่าน
          </button>
        </div>
      )}

      {/* ═══ Tab: Notifications ═══ */}
      {tab === 'notifications' && (
        <div className="space-y-2">
          {[
            {key:'formRemind', label:'แจ้งเตือนฟอร์มค้าง', desc:'เตือนเมื่อมีฟอร์มที่ยังไม่ได้ทำ'},
            {key:'dailyReport', label:'สรุปรายวัน', desc:'ส่งสรุปผลทุกเย็น 18:00'},
            {key:'urgentAlert', label:'แจ้งเตือนฉุกเฉิน', desc:'อุบัติเหตุ เหตุฉุกเฉิน'},
            {key:'lineNotif', label:'แจ้งเตือนผ่าน LINE', desc:'ส่ง notification ผ่าน LINE'},
            {key:'emailNotif', label:'แจ้งเตือนผ่านอีเมล', desc:'ส่ง email สรุปงาน'},
          ].map(n => (
            <div key={n.key} className="rounded-xl border border-white/[0.06] bg-white/[0.02] p-4 flex items-center justify-between">
              <div>
                <p className="text-sm text-white font-medium">{n.label}</p>
                <p className="text-[13px] text-neutral-500">{n.desc}</p>
              </div>
              <button onClick={() => setNotiSettings(p => ({...p, [n.key]: !p[n.key]}))}
                className={cn('w-11 h-6 rounded-full relative cursor-pointer transition-colors shrink-0',
                  notiSettings[n.key] ? 'bg-yellow-400' : 'bg-neutral-700')}>
                <div className={cn('w-5 h-5 rounded-full bg-white absolute top-0.5 transition-all',
                  notiSettings[n.key] ? 'left-[22px]' : 'left-0.5')} />
              </button>
            </div>
          ))}
        </div>
      )}

      {/* ═══ Tab: Rewards ═══ */}
      {tab === 'rewards' && (() => {
        const sc = userScore || 0;
        const levels = [{min:0,name:'เริ่มต้น',icon:'🌱',next:50},{min:50,name:'มือใหม่',icon:'⭐',next:120},{min:120,name:'ชำนาญ',icon:'🔥',next:200},{min:200,name:'เชี่ยวชาญ',icon:'💎',next:300},{min:300,name:'ระดับเพชร',icon:'👑',next:999}];
        const cur = [...levels].reverse().find(l => sc >= l.min) || levels[0];
        const nxt = levels[levels.indexOf(cur) + 1] || cur;
        const pct = nxt.next > cur.min ? Math.round(((sc - cur.min) / (nxt.next - cur.min)) * 100) : 100;
        const rewards = [
          {target:50,name:'คูปองกาแฟ',desc:'แลกเครื่องดื่ม 1 แก้ว',icon:'☕',cl:'#F59E0B'},
          {target:120,name:'บัตรเติมน้ำมัน 200 บาท',desc:'ใช้ได้ทุกปั๊ม',icon:'⛽',cl:'#60A5FA'},
          {target:200,name:'ส่วนลดต่อ พ.ร.บ. 10%',desc:'บริการต่อ พ.ร.บ. รถ',icon:'📋',cl:'#34D399'},
          {target:300,name:'ประกันภัยอุบัติเหตุ',desc:'คุ้มครอง 1 ปี',icon:'🛡️',cl:'#A78BFA'},
          {target:500,name:'ทริปท่องเที่ยว',desc:'สำหรับ Top 5 คะแนนสูงสุด',icon:'✈️',cl:'#F87171'},
        ];
        const badges = [];
        if (sc >= 10) badges.push({icon:'🎯',name:'เริ่มต้นดี'});
        if (sc >= 50) badges.push({icon:'💪',name:'ขยันเกินร้อย'});
        if (sc >= 100) badges.push({icon:'💯',name:'ร้อยแต้ม'});
        if (sc >= 200) badges.push({icon:'🌟',name:'ดาวทอง'});
        if (sc >= 300) badges.push({icon:'👑',name:'ระดับเพชร'});
        return (
          <div className="space-y-4">
            {/* Level card */}
            <div className="rounded-2xl p-5 text-center" style={{background:'linear-gradient(135deg,rgba(251,191,36,0.08),transparent)',border:'1px solid rgba(251,191,36,0.15)'}}>
              <div className="text-4xl mb-2">{cur.icon}</div>
              <p className="text-lg font-bold text-yellow-400">{cur.name}</p>
              <p className="text-3xl font-black text-white my-2">{sc}</p>
              <p className="text-[13px] text-neutral-500">คะแนนสะสมรวม</p>
              <div className="max-w-xs mx-auto mt-3">
                <div className="h-2.5 rounded-full bg-neutral-800 overflow-hidden">
                  <div className="h-full rounded-full" style={{width:pct+'%',background:'linear-gradient(90deg,#FBBF24,#34D399)',transition:'width 0.5s'}}/>
                </div>
                {nxt !== cur && <p className="text-[13px] text-neutral-500 mt-1">อีก {nxt.next - sc} คะแนนถึง {nxt.icon} {nxt.name}</p>}
              </div>
            </div>

            {/* Badges */}
            <div className="rounded-2xl p-4" style={{border:'1px solid rgba(167,139,250,0.15)',background:'linear-gradient(135deg,rgba(167,139,250,0.04),transparent)'}}>
              <div className="flex items-center gap-2 mb-3">
                <Icon type="shield" className="h-4 w-4 text-purple-400"/>
                <p className="text-sm font-bold text-purple-400">เหรียญที่สะสมได้ ({badges.length}/5)</p>
              </div>
              <div className="grid grid-cols-5 gap-2">
                {[{t:10,icon:'🎯',n:'เริ่มต้นดี'},{t:50,icon:'💪',n:'ขยัน'},{t:100,icon:'💯',n:'ร้อยแต้ม'},{t:200,icon:'🌟',n:'ดาวทอง'},{t:300,icon:'👑',n:'เพชร'}].map((b,i) => {
                  const unlocked = sc >= b.t;
                  return (
                    <div key={i} className="rounded-xl p-2 text-center" style={{background:unlocked?'rgba(167,139,250,0.1)':'rgba(255,255,255,0.02)',border:unlocked?'1px solid rgba(167,139,250,0.2)':'1px solid rgba(255,255,255,0.04)',opacity:unlocked?1:0.4}}>
                      <div className="text-2xl mb-1">{unlocked ? b.icon : '🔒'}</div>
                      <p className="text-[13px] text-neutral-400">{b.n}</p>
                      <p className="text-[13px] text-neutral-600">{b.t} pt</p>
                    </div>
                  );
                })}
              </div>
            </div>

            {/* Rewards / Goals */}
            <div className="rounded-2xl overflow-hidden" style={{border:'1px solid rgba(52,211,153,0.15)'}}>
              <div style={{height:3,background:'linear-gradient(90deg,#34D399,#FBBF24,transparent)'}}/>
              <div className="p-4" style={{background:'linear-gradient(135deg,rgba(52,211,153,0.04),transparent)'}}>
                <div className="flex items-center gap-2 mb-3">
                  <span className="text-base">🎁</span>
                  <p className="text-sm font-bold text-emerald-400">เป้าหมาย — สะสมคะแนนแลกรางวัล</p>
                </div>
                {rewards.map((r,i) => {
                  const reached = sc >= r.target;
                  const progress = Math.min(100, Math.round((sc / r.target) * 100));
                  return (
                    <div key={i} className="flex items-center gap-3 py-3 transition-all duration-150"
                      style={{borderBottom:i<rewards.length-1?'1px solid rgba(255,255,255,0.04)':'none'}}>
                      <div className="w-10 h-10 rounded-xl flex items-center justify-center text-xl shrink-0" style={{background:reached?r.cl+'20':'rgba(255,255,255,0.03)'}}>{r.icon}</div>
                      <div className="flex-1 min-w-0">
                        <div className="flex items-center gap-2">
                          <p className="text-sm font-medium" style={{color:reached?r.cl:'white'}}>{r.name}</p>
                          {reached && <span className="text-[13px] font-bold px-1.5 py-0.5 rounded" style={{background:r.cl+'20',color:r.cl}}>แลกได้!</span>}
                        </div>
                        <p className="text-[13px] text-neutral-500">{r.desc}</p>
                        {!reached && (
                          <div className="flex items-center gap-2 mt-1">
                            <div className="flex-1 h-1.5 rounded-full bg-neutral-800 overflow-hidden max-w-[120px]"><div className="h-full rounded-full" style={{width:progress+'%',background:r.cl}}/></div>
                            <span className="text-[13px] text-neutral-600">{sc}/{r.target}</span>
                          </div>
                        )}
                      </div>
                      {reached ? (
                        <button className="px-3 py-1.5 rounded-lg text-[13px] font-bold cursor-pointer" style={{background:r.cl+'20',color:r.cl}}>แลกรางวัล</button>
                      ) : (
                        <span className="text-[13px] text-neutral-600 shrink-0">อีก {r.target - sc}</span>
                      )}
                    </div>
                  );
                })}
              </div>
            </div>

            {/* Monthly leaderboard teaser */}
            <div className="rounded-2xl p-4" style={{border:'1px solid rgba(255,255,255,0.06)',background:'rgba(255,255,255,0.02)'}}>
              <div className="flex items-center gap-2 mb-3">
                <span className="text-base">🏆</span>
                <p className="text-sm font-bold text-yellow-400">อันดับประจำเดือน มี.ค. 2569</p>
              </div>
              {[
                {rank:1,name:'ประเสริฐ รถมั่นคง',score:245,icon:'🥇'},
                {rank:2,name:'สุรชัย ขับดี',score:198,icon:'🥈'},
                {rank:3,name:'อนันต์ ปลอดภัย',score:167,icon:'🥉'},
              ].map((p,i) => (
                <div key={i} className="flex items-center gap-3 py-2" style={{borderBottom:i<2?'1px solid rgba(255,255,255,0.04)':'none'}}>
                  <span className="text-lg w-8 text-center">{p.icon}</span>
                  <p className="text-sm text-white flex-1">{p.name}</p>
                  <span className="text-sm font-bold text-yellow-400">{p.score}</span>
                </div>
              ))}
            </div>
          </div>
        );
      })()}

      {/* ═══ Tab: Activity ═══ */}
      {tab === 'activity' && (
        <div className="rounded-xl border border-white/[0.06] bg-white/[0.02] p-4">
          <p className="text-sm font-bold text-white mb-3">ประวัติเข้าใช้งานล่าสุด</p>
          {[
            {d:'29 มี.ค. 2569', t:'07:25', device:'Chrome • Windows', ip:'182.53.xxx.xxx'},
            {d:'28 มี.ค. 2569', t:'07:30', device:'LINE Browser • Android', ip:'182.53.xxx.xxx'},
            {d:'27 มี.ค. 2569', t:'08:00', device:'Safari • iPhone', ip:'110.168.xxx.xxx'},
            {d:'26 มี.ค. 2569', t:'07:15', device:'Chrome • Windows', ip:'182.53.xxx.xxx'},
            {d:'25 มี.ค. 2569', t:'07:45', device:'LINE Browser • Android', ip:'182.53.xxx.xxx'},
          ].map((h,i) => (
            <div key={i} className="flex items-center gap-3 py-2.5 border-b border-white/5 last:border-0">
              <div className="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center shrink-0">
                <Icon type="clock" className="h-3.5 w-3.5 text-neutral-500" />
              </div>
              <div className="flex-1 min-w-0">
                <p className="text-sm text-white">{h.d} • {h.t}</p>
                <p className="text-[13px] text-neutral-500">{h.device}</p>
              </div>
              <span className="text-[13px] text-neutral-600">{h.ip}</span>
            </div>
          ))}
        </div>
      )}
      </div>
    </div>
  );
}

function AssignWorkView({ role, onNavigate }) {
  const [viewMode, setViewMode] = useState('assign');
  const [acceptedTasks, setAcceptedTasks] = useState([]);
  const [step, setStep] = useState(1);
  const [selectedUser, setSelectedUser] = useState(null);
  const [selectedForms, setSelectedForms] = useState([]);
  const [done, setDone] = useState(false);
  const [showFW, setShowFW] = useState(false);
  const [assignDate, setAssignDate] = useState('');
  const [assignTime, setAssignTime] = useState('');
  const [notifBefore, setNotifBefore] = useState('30');
  const [note, setNote] = useState('');

  const allUsers = [
    { id:0, name:'สมชาย ใจดี', role:'TSM', vehicle:'—', assignable:'owner' },
    { id:1, name:'ประเสริฐ รถมั่นคง', role:'ผู้ขับรถ', vehicle:'กน-1658', assignable:'all' },
    { id:2, name:'สุรชัย ขับดี', role:'ผู้ขับรถ', vehicle:'1กฐ-6852', assignable:'all' },
    { id:3, name:'อนันต์ ปลอดภัย', role:'ผู้ขับรถ', vehicle:'บท-3091', assignable:'all' },
    { id:4, name:'วิชัย ส่งด่วน', role:'ผู้ขับรถ', vehicle:'ผก-2244', assignable:'all' },
    { id:5, name:'สมศักดิ์ ถนนดี', role:'ผู้ขับรถ', vehicle:'2กจ-8103', assignable:'all' },
    { id:6, name:'สุภาพร ร่วมงาน', role:'เจ้าหน้าที่', vehicle:'—', assignable:'tsm' },
  ];
  // Owner → จ่ายให้ TSM ได้ | TSM → จ่ายให้ ผู้ขับ/เจ้าหน้าที่/ตัวเอง
  const users = role === 'manager'
    ? allUsers.filter(u => u.assignable === 'owner' || u.assignable === 'all')
    : allUsers.filter(u => u.assignable === 'all' || u.assignable === 'tsm');

  const today = new Date().toISOString().slice(0,10);
  const nowTime = new Date().toLocaleTimeString('th-TH',{hour:'2-digit',minute:'2-digit'});
  const displayDate = assignDate || today;
  const displayTime = assignTime || nowTime;

  React.useEffect(() => {
    if (showFW) { const t = setTimeout(() => setShowFW(false), 2500); return () => clearTimeout(t); }
  }, [showFW]);

  if (done) {
    const user = users.find(u => u.id === selectedUser);
    return (
      <div className="space-y-3">
        {showFW && <Fireworks />}

        {/* ── Celebration banner ── */}
        <div className="rounded-2xl overflow-hidden" style={{boxShadow:'0 4px 20px rgba(0,0,0,0.3)'}}>
          <div className="p-6 text-center" style={{background:'linear-gradient(135deg,#FBBF24,#F59E0B)'}}>
            <div className="text-5xl mb-3">🎉</div>
            <h2 style={{fontSize:22,fontWeight:800,color:'#1a1a1a',margin:0}}>จ่ายงานสำเร็จ!</h2>
            <p style={{fontSize:14,color:'rgba(0,0,0,0.6)',marginTop:4}}>ส่ง {selectedForms.length} ฟอร์มให้ {user?.name} เรียบร้อยแล้ว</p>
          </div>
        </div>

        {/* ── สถานะเอกสาร flow ── */}
        <div className="rounded-2xl overflow-hidden" style={{border:'1px solid rgba(255,255,255,0.06)',boxShadow:'0 4px 16px rgba(0,0,0,0.2)'}}>
          <div className="px-4 py-2.5" style={{background:'linear-gradient(135deg,#FBBF24,#F59E0B)'}}>
            <p style={{fontSize:14,fontWeight:800,color:'#1a1a1a',margin:0}}>สถานะเอกสาร</p>
          </div>
          <div className="p-4">
            <div className="flex items-center justify-between mb-4">
              {[
                {label:'บันทึก',icon:'check',active:true,cl:'#34D399'},
                {label:'ย้าย',icon:'send',active:true,cl:'#60A5FA'},
                {label:'ส่ง',icon:'send',active:true,cl:'#A78BFA'},
                {label:'สำเร็จ',icon:'shield',active:true,cl:'#FBBF24'},
              ].map((s,i) => (
                <React.Fragment key={i}>
                  <div className="flex flex-col items-center gap-1">
                    <div className="w-10 h-10 rounded-xl flex items-center justify-center" style={{background:s.active?s.cl+'20':'rgba(255,255,255,0.04)'}}>
                      <Icon type={s.icon} className="h-4 w-4" style={{color:s.active?s.cl:'rgba(255,255,255,0.2)'}}/>
                    </div>
                    <span className="text-[13px] font-bold" style={{color:s.active?s.cl:'rgba(255,255,255,0.3)'}}>{s.label}</span>
                  </div>
                  {i < 3 && <div className="flex-1 h-0.5 rounded mx-1" style={{background:s.active?'linear-gradient(90deg,'+s.cl+','+[{cl:'#60A5FA'},{cl:'#A78BFA'},{cl:'#FBBF24'}][i].cl+')':'rgba(255,255,255,0.06)',marginTop:-12}}/>}
                </React.Fragment>
              ))}
            </div>
            <div className="rounded-xl p-3 flex items-center gap-2" style={{background:'rgba(52,211,153,0.05)',border:'1px solid rgba(52,211,153,0.1)'}}>
              <span className="text-base">✅</span>
              <p className="text-[13px] text-neutral-400">เอกสารถูก <span className="text-emerald-400 font-bold">บันทึก</span> → <span className="text-sky-400 font-bold">ย้ายไปผู้รับ</span> → <span className="text-purple-400 font-bold">ส่ง</span>ถึง {user?.name} → <span className="text-yellow-400 font-bold">สำเร็จ</span></p>
            </div>
          </div>
        </div>

        {/* ── สรุปงานที่จ่าย ── */}
        <div className="rounded-2xl p-4" style={{border:'1px solid rgba(255,255,255,0.06)',boxShadow:'0 4px 16px rgba(0,0,0,0.2)'}}>
          <div className="flex items-center gap-3 mb-3">
            <div className="w-10 h-10 rounded-xl flex items-center justify-center text-sm font-bold text-white shrink-0" style={{background:user?.role==='TSM'?'linear-gradient(135deg,#A78BFA,#7C3AED)':'linear-gradient(135deg,#FBBF24,#F59E0B)'}}>{user?.name[0]}</div>
            <div className="flex-1"><p className="text-sm font-bold text-white">{user?.name}</p><p className="text-[13px] text-neutral-500">{user?.role} • {user?.vehicle}</p></div>
          </div>
          <div className="grid grid-cols-3 gap-2 mb-3">
            <div className="rounded-xl p-2 text-center" style={{background:'rgba(96,165,250,0.06)',border:'1px solid rgba(96,165,250,0.1)'}}>
              <p className="text-sm font-bold text-sky-400">{displayDate}</p><p className="text-[13px] text-neutral-500">วันที่</p>
            </div>
            <div className="rounded-xl p-2 text-center" style={{background:'rgba(96,165,250,0.06)',border:'1px solid rgba(96,165,250,0.1)'}}>
              <p className="text-sm font-bold text-sky-400">{displayTime}</p><p className="text-[13px] text-neutral-500">เวลา</p>
            </div>
            <div className="rounded-xl p-2 text-center" style={{background:'rgba(251,191,36,0.06)',border:'1px solid rgba(251,191,36,0.1)'}}>
              <p className="text-sm font-bold text-yellow-400">{notifBefore === 'ทันที' ? 'ทันที' : notifBefore+' นาที'}</p><p className="text-[13px] text-neutral-500">แจ้งเตือน</p>
            </div>
          </div>
          {note && (
            <div className="rounded-xl p-2.5 flex items-start gap-2 mb-3" style={{background:'rgba(251,191,36,0.05)',border:'1px solid rgba(251,191,36,0.1)'}}>
              <span className="text-sm">💬</span><p className="text-[13px] text-yellow-400">{note}</p>
            </div>
          )}
          <div className="text-[13px] text-neutral-500">{selectedForms.length} ฟอร์ม: {selectedForms.map(fid => FORMS.find(x=>x.id===fid)?.name).join(', ')}</div>
        </div>

        {/* ── แจ้งเตือน ── */}
        <div className="rounded-2xl overflow-hidden" style={{border:'1px solid rgba(52,211,153,0.15)',boxShadow:'0 4px 16px rgba(0,0,0,0.2)'}}>
          <div className="px-4 py-2.5" style={{background:'linear-gradient(135deg,#FBBF24,#F59E0B)'}}>
            <p style={{fontSize:14,fontWeight:800,color:'#1a1a1a',margin:0}}>การแจ้งเตือน</p>
          </div>
          <div className="p-3">
            {[
              {text:user?.name+' ได้รับแจ้งเตือนทาง LINE แล้ว',icon:'check',cl:'#34D399'},
              {text:'ระบบจะแจ้งเตือนอีกครั้ง '+(notifBefore==='ทันที'?'ทันที':notifBefore+' นาทีก่อนเวลา'),icon:'bell',cl:'#FBBF24'},
              {text:'เมื่อ '+user?.name+' เริ่มทำฟอร์ม คุณจะได้รับแจ้งเตือน',icon:'bell',cl:'#60A5FA'},
              {text:'เมื่อทำเสร็จ สถานะจะเปลี่ยนเป็น "สำเร็จ" อัตโนมัติ',icon:'shield',cl:'#A78BFA'},
            ].map((n,i) => (
              <div key={i} className="flex items-center gap-2.5 px-2 py-2 rounded-xl" style={{borderBottom:i<3?'1px solid rgba(255,255,255,0.03)':'none'}}>
                <div className="w-6 h-6 rounded-lg flex items-center justify-center shrink-0" style={{background:n.cl+'15'}}><Icon type={n.icon} className="h-3 w-3" style={{color:n.cl}}/></div>
                <p className="text-[13px] text-neutral-400">{n.text}</p>
              </div>
            ))}
          </div>
        </div>

        {/* ── QR + Share ── */}
        <div className="rounded-2xl p-4 text-center" style={{border:'1px solid rgba(255,255,255,0.06)',boxShadow:'0 4px 16px rgba(0,0,0,0.2)'}}>
          <div className="inline-block rounded-2xl border border-white/10 bg-white p-3 mb-3">
            <svg viewBox="0 0 100 100" width="100" height="100">
              <rect x="5" y="5" width="90" height="90" rx="4" fill="none" stroke="#222" strokeWidth="2"/>
              {[15,30,45,60,75].map(x => [15,30,45,60,75].map(y =>
                <rect key={x+'-'+y} x={x} y={y} width="10" height="10" rx="1" fill={Math.random()>0.3?'#222':'#fff'}/>
              ))}
              <rect x="35" y="35" width="30" height="30" rx="2" fill="#fff" stroke="#222" strokeWidth="1.5"/>
              <text x="50" y="54" textAnchor="middle" fontSize="10" fontWeight="bold" fill="#222">TSMC</text>
            </svg>
          </div>
          <p className="text-[13px] text-neutral-500 mb-3">สแกน QR หรือแชร์ลิงก์</p>
          <div className="flex gap-2 justify-center">
            <button className="px-4 py-2 rounded-xl text-sm font-bold cursor-pointer" style={{background:'rgba(52,211,153,0.1)',color:'#34D399'}}>คัดลอกลิงก์</button>
            <button className="px-4 py-2 rounded-xl text-sm font-bold cursor-pointer" style={{background:'rgba(96,165,250,0.1)',color:'#60A5FA'}}>แชร์ LINE</button>
            <button onClick={() => { setDone(false); setStep(1); setSelectedUser(null); setSelectedForms([]); setNote(''); setAssignDate(''); setAssignTime(''); }}
              className="px-4 py-2 rounded-xl text-sm font-bold cursor-pointer" style={{background:'rgba(251,191,36,0.1)',color:'#FBBF24'}}>จ่ายงานใหม่</button>
          </div>
        </div>
      </div>
    );
  }

  return (
    <div>
      {/* Progress steps */}
      <div className="flex gap-1.5 mb-4">
        {[{s:1,l:'ผู้รับงาน'},{s:2,l:'ฟอร์ม'},{s:3,l:'เวลา/หมายเหตุ'},{s:4,l:'ยืนยัน'}].map(s => (
          <div key={s.s} className="flex-1">
            <div className={cn('h-1.5 rounded-full mb-1', step >= s.s ? 'bg-yellow-400' : 'bg-white/10')} />
            <p className={cn('text-[13px] text-center', step >= s.s ? 'text-yellow-400' : 'text-neutral-600')}>{s.l}</p>
          </div>
        ))}
      </div>

      {/* TSM: Tab switcher — รับงาน / จ่ายงาน */}
      {role === 'tsm' && step === 1 && (
        <div className="flex gap-1 p-1 rounded-2xl mb-3" style={{background:'#0d1a2e',border:'1px solid rgba(255,255,255,0.06)'}}>
          {[{id:'assign',l:'จ่ายงาน',count:0},{id:'inbox',l:'งานที่ได้รับ',count:3}].map(t => (
            <button key={t.id} onClick={() => setViewMode(t.id)}
              className="flex-1 py-2.5 rounded-xl text-sm font-bold cursor-pointer transition-all flex items-center justify-center gap-2"
              style={{background:viewMode===t.id?'linear-gradient(135deg,#FBBF24,#F59E0B)':'transparent',color:viewMode===t.id?'#1a1a1a':'rgba(255,255,255,0.4)'}}>
              {t.l}
              {t.count > 0 && <span className="text-[13px] px-1.5 py-0.5 rounded-md" style={{background:viewMode===t.id?'rgba(0,0,0,0.15)':'rgba(248,113,113,0.15)',color:viewMode===t.id?'#1a1a1a':'#F87171'}}>{t.count}</span>}
            </button>
          ))}
        </div>
      )}

      {/* TSM Inbox — งานที่ได้รับจากเจ้าของกิจการ */}
      {role === 'tsm' && step === 1 && viewMode === 'inbox' && (
        <div className="space-y-2">
          <p className="text-sm text-neutral-400 mb-2">งานที่ได้รับจากเจ้าของกิจการ</p>
          {[
            {id:'t1',from:'นภา บริหาร',role:'เจ้าของกิจการ',task:'ตรวจสภาพรถทุกคัน + ROLLCALL พรุ่งนี้',forms:['F01','F02'],date:'31 มี.ค. 2569',time:'07:00',note:'ลูกค้ารายใหญ่มารับของ เตรียมรถให้พร้อม',status:'รอรับ',cl:'#F87171'},
            {id:'t2',from:'นภา บริหาร',role:'เจ้าของกิจการ',task:'จัดอบรมขับรถปลอดภัยให้วิชัย',forms:['F13'],date:'5 เม.ย. 2569',time:'09:00',note:'วิชัยยังไม่ผ่านอบรม ห้ามขับจนกว่าจะผ่าน',status:'รอรับ',cl:'#FBBF24'},
            {id:'t3',from:'นภา บริหาร',role:'เจ้าของกิจการ',task:'ต่อ พ.ร.บ. รถ บบ-7765',forms:[],date:'10 เม.ย. 2569',time:'—',note:'หมดอายุแล้ว 14 วัน ดำเนินการด่วน',status:'รอรับ',cl:'#F87171'},
          ].map((task,i) => (
            <div key={i} className="rounded-2xl overflow-hidden" style={{border:'1px solid '+task.cl+'25',boxShadow:'0 4px 16px rgba(0,0,0,0.2)'}}>
              <div className="p-4" style={{background:task.cl+'06'}}>
                <div className="flex items-center gap-2 mb-2">
                  <div className="w-8 h-8 rounded-xl flex items-center justify-center text-[13px] font-bold text-white shrink-0" style={{background:'linear-gradient(135deg,#60A5FA,#3B82F6)'}}>{task.from[0]}</div>
                  <div className="flex-1 min-w-0">
                    <div className="flex items-center gap-1.5"><p className="text-sm text-white font-medium">{task.from}</p><span className="text-[13px] px-1.5 py-0.5 rounded" style={{background:'rgba(96,165,250,0.15)',color:'#60A5FA'}}>{task.role}</span></div>
                    <p className="text-[13px] text-neutral-500">{task.date} {task.time !== '—' ? '• '+task.time : ''}</p>
                  </div>
                  <span className="text-[13px] font-bold px-2 py-0.5 rounded-lg" style={{background:task.cl+'15',color:task.cl}}>{task.status}</span>
                </div>
                <p className="text-sm text-white font-bold mb-1">{task.task}</p>
                {task.forms.length > 0 && <p className="text-[13px] text-neutral-500 mb-1">ฟอร์ม: {task.forms.join(', ')}</p>}
                {task.note && (
                  <div className="rounded-lg p-2 flex items-start gap-2 mb-3" style={{background:'rgba(251,191,36,0.05)',border:'1px solid rgba(251,191,36,0.1)'}}>
                    <span className="text-sm">💬</span>
                    <p className="text-[13px] text-yellow-400">{task.note}</p>
                  </div>
                )}
                <div className="flex gap-2">
                  <button onClick={() => { setViewMode('assign'); }}
                    className="flex-1 h-10 rounded-xl text-sm font-bold cursor-pointer flex items-center justify-center gap-1.5" style={{background:'rgba(167,139,250,0.1)',border:'1px solid rgba(167,139,250,0.2)',color:'#A78BFA'}}>
                    จ่ายงานต่อ
                  </button>
                  <button onClick={() => { setAcceptedTasks(prev => [...prev, task.id]); if(onNavigate) onNavigate('dailyOps'); if(window._setPageKey) window._setPageKey('dailyOps'); }}
                    className="flex-1 h-10 rounded-xl text-sm font-bold cursor-pointer flex items-center justify-center gap-1.5" style={{background:'linear-gradient(135deg,#FBBF24,#F59E0B)',color:'#1a1a1a'}}>
                    รับงาน → ไปงานประจำวัน
                  </button>
                </div>
              </div>
            </div>
          ))}
        </div>
      )}

      {/* Step 1: Select user — only show when in assign mode */}
      {(role !== 'tsm' || viewMode === 'assign') && step === 1 && (
        <div className="space-y-2">
          <p className="text-sm text-neutral-400 mb-2">{role === 'manager' ? 'จ่ายงานให้ TSM หรือผู้ขับรถ' : 'เลือกผู้รับงาน หรือทำเอง'}</p>
          {/* TSM: ทำเอง option */}
          {role === 'tsm' && (
            <button onClick={() => { setSelectedUser(0); setStep(2); }}
              className="w-full text-left rounded-xl p-3 flex items-center gap-3 cursor-pointer transition-all"
              style={{border:'1px solid rgba(251,191,36,0.2)',background:'rgba(251,191,36,0.05)'}}
              onMouseEnter={e=>{e.currentTarget.style.background='rgba(251,191,36,0.1)';e.currentTarget.style.transform='translateX(4px)';}}
              onMouseLeave={e=>{e.currentTarget.style.background='rgba(251,191,36,0.05)';e.currentTarget.style.transform='';}}>
              <div className="w-10 h-10 rounded-xl flex items-center justify-center shrink-0" style={{background:'linear-gradient(135deg,#FBBF24,#F59E0B)'}}>
                <Icon type="users" className="h-5 w-5" style={{color:'#1a1a1a'}}/>
              </div>
              <div className="flex-1"><p className="text-sm font-bold text-yellow-400">ทำเอง (สมชาย ใจดี)</p><p className="text-[13px] text-neutral-500">TSM • จ่ายงานให้ตัวเอง</p></div>
              <span className="text-[13px] font-bold px-2 py-0.5 rounded" style={{background:'rgba(251,191,36,0.15)',color:'#FBBF24'}}>ฉัน</span>
            </button>
          )}
          {/* Owner info banner */}
          {role === 'manager' && (
            <div className="rounded-xl p-2.5 flex items-center gap-2 mb-1" style={{background:'rgba(96,165,250,0.05)',border:'1px solid rgba(96,165,250,0.1)'}}>
              <Icon type="building" className="h-3.5 w-3.5 text-sky-400 shrink-0"/>
              <p className="text-[13px] text-neutral-400">จ่ายให้ <span className="text-sky-400 font-bold">TSM</span> แล้ว TSM มอบหมายต่อให้ผู้ขับได้</p>
            </div>
          )}
          {users.map(u => (
            <button key={u.id} onClick={() => { setSelectedUser(u.id); setStep(2); }}
              className="w-full text-left rounded-xl border border-white/5 bg-white/[0.02] p-3 flex items-center gap-3 hover:border-yellow-400/20 cursor-pointer transition-all">
              <div className="w-10 h-10 rounded-xl flex items-center justify-center text-white text-sm font-bold shrink-0" style={{background:u.role==='TSM'?'linear-gradient(135deg,#A78BFA,#7C3AED)':u.role==='เจ้าหน้าที่'?'linear-gradient(135deg,#60A5FA,#3B82F6)':'linear-gradient(135deg,#FBBF24,#F59E0B)'}}>{u.name[0]}</div>
              <div className="flex-1">
                <div className="flex items-center gap-1.5"><p className="text-sm font-medium text-white">{u.name}</p><span className="text-[13px] px-1.5 py-0.5 rounded" style={{background:u.role==='TSM'?'rgba(167,139,250,0.15)':u.role==='เจ้าหน้าที่'?'rgba(96,165,250,0.15)':'rgba(251,191,36,0.15)',color:u.role==='TSM'?'#A78BFA':u.role==='เจ้าหน้าที่'?'#60A5FA':'#FBBF24'}}>{u.role}</span></div>
                <p className="text-[13px] text-neutral-500">{u.vehicle}</p>
              </div>
              <Icon type="arrowRight" className="h-4 w-4 text-neutral-600" />
            </button>
          ))}
        </div>
      )}

      {/* Step 2: Select forms */}
      {step === 2 && (
        <div>
          <p className="text-sm text-neutral-400 mb-2">เลือกฟอร์มที่จ่าย</p>
          {[1,2,3,4,5,0].map(tier => {
            const tf = FORMS.filter(f => f.tier === tier);
            if (!tf.length) return null;
            return (
              <div key={tier} className="mb-3">
                <p className="text-sm font-bold text-yellow-400 mb-1.5">{tier===0?'บริหาร':`Tier ${tier}: ${TIER_NAMES[tier]}`}</p>
                <div className="space-y-1">
                  {tf.map(f => {
                    const sel = selectedForms.includes(f.id);
                    return (
                      <button key={f.id} onClick={() => setSelectedForms(prev => sel ? prev.filter(x=>x!==f.id) : [...prev, f.id])}
                        className={cn('w-full text-left rounded-lg border p-2.5 flex items-center gap-2 cursor-pointer transition-all text-sm',
                          sel ? 'border-yellow-400/30 bg-yellow-400/[0.05] text-yellow-400' : 'border-white/5 bg-white/[0.02] text-white hover:border-white/10')}>
                        <div className={cn('w-5 h-5 rounded border flex items-center justify-center shrink-0 text-[13px]',
                          sel ? 'bg-yellow-400 border-yellow-400 text-neutral-900' : 'border-white/15')}>
                          {sel && '✓'}
                        </div>
                        {f.name}
                      </button>
                    );
                  })}
                </div>
              </div>
            );
          })}
          <div className="flex gap-2 mt-4">
            <button onClick={() => setStep(1)} className="flex-1 h-10 rounded-xl border border-white/10 text-neutral-400 text-sm cursor-pointer">← ย้อนกลับ</button>
            <button onClick={() => { if(selectedForms.length) setStep(3); }}
              className={cn('flex-1 h-10 rounded-xl text-sm font-bold cursor-pointer transition',
                selectedForms.length ? 'bg-yellow-400 text-neutral-900' : 'bg-white/5 text-neutral-600 cursor-not-allowed')}>
              เลือก {selectedForms.length} ฟอร์ม →
            </button>
          </div>
        </div>
      )}

      {/* Step 3: Date/Time + Notification + Note */}
      {step === 3 && (
        <div className="space-y-4">
          <p className="text-sm text-neutral-400">กำหนดเวลาและหมายเหตุ</p>

          {/* Date & Time — pre-filled with current */}
          <div className="rounded-2xl p-4" style={{border:'1px solid rgba(96,165,250,0.15)',background:'rgba(96,165,250,0.04)'}}>
            <div className="flex items-center gap-2 mb-3">
              <Icon type="clock" className="h-4 w-4 text-sky-400"/>
              <p className="text-sm font-bold text-sky-400">วันที่และเวลา</p>
            </div>
            {/* Quick date buttons */}
            <div className="flex gap-2 mb-3">
              {[
                {l:'วันนี้',d:today},
                {l:'พรุ่งนี้',d:(() => { const d = new Date(); d.setDate(d.getDate()+1); return d.toISOString().slice(0,10); })()},
                {l:'มะรืนนี้',d:(() => { const d = new Date(); d.setDate(d.getDate()+2); return d.toISOString().slice(0,10); })()},
              ].map(q => (
                <button key={q.l} onClick={() => setAssignDate(q.d)}
                  className={cn('flex-1 py-2 rounded-xl text-[13px] font-medium cursor-pointer transition-all',
                    (assignDate || today) === q.d ? 'text-neutral-900' : 'text-neutral-400')}
                  style={{background:(assignDate || today) === q.d ? 'linear-gradient(135deg,#60A5FA,#3B82F6)' : 'rgba(255,255,255,0.03)',
                    border:(assignDate || today) === q.d ? 'none' : '1px solid rgba(255,255,255,0.06)',
                    color:(assignDate || today) === q.d ? 'white' : undefined}}>
                  {q.l}
                </button>
              ))}
            </div>
            {/* Date + Time inline */}
            <div className="flex items-center gap-2 rounded-xl p-3" style={{background:'rgba(255,255,255,0.03)',border:'1px solid rgba(255,255,255,0.06)'}}>
              <Icon type="clock" className="h-4 w-4 text-sky-400 shrink-0"/>
              <span className="text-sm text-sky-400 font-bold">{displayDate}</span>
              <span className="text-sm text-neutral-500">เวลา</span>
              <span className="text-sm text-sky-400 font-bold">{displayTime}</span>
              <span className="text-[13px] text-emerald-400 ml-auto px-1.5 py-0.5 rounded" style={{background:'rgba(52,211,153,0.1)'}}>default</span>
            </div>
          </div>

          {/* Notification setting */}
          <div className="rounded-2xl p-4" style={{border:'1px solid rgba(251,191,36,0.15)',background:'rgba(251,191,36,0.04)'}}>
            <div className="flex items-center gap-2 mb-3">
              <Icon type="bell" className="h-4 w-4 text-yellow-400"/>
              <p className="text-sm font-bold text-yellow-400">แจ้งเตือนก่อนเวลา</p>
            </div>
            <div className="flex gap-2">
              {['ทันที','15','30','60','120'].map(m => (
                <button key={m} onClick={() => setNotifBefore(m)}
                  className={cn('flex-1 py-2 rounded-xl text-[13px] font-medium cursor-pointer transition-all',
                    notifBefore === m ? 'text-neutral-900' : 'text-neutral-500')}
                  style={{background: notifBefore === m ? 'linear-gradient(135deg,#FBBF24,#F59E0B)' : 'rgba(255,255,255,0.03)',
                    border: notifBefore === m ? 'none' : '1px solid rgba(255,255,255,0.06)'}}>
                  {m === 'ทันที' ? 'ทันที' : m + ' นาที'}
                </button>
              ))}
            </div>
          </div>

          {/* Note for receiver */}
          <div className="rounded-2xl p-4" style={{border:'1px solid rgba(255,255,255,0.06)'}}>
            <div className="flex items-center gap-2 mb-3">
              <Icon type="file" className="h-4 w-4 text-neutral-400"/>
              <p className="text-sm font-bold text-white">หมายเหตุถึงผู้รับงาน</p>
              <span className="text-[13px] text-neutral-600 ml-auto">ไม่บังคับ</span>
            </div>
            {/* Quick presets */}
            <div className="flex flex-wrap gap-1.5 mb-2">
              {['ตรวจสภาพรถให้ดี','เช็คน้ำมันก่อนออก','ลูกค้ารอของด่วน','เส้นทางมีก่อสร้าง','ระวังฝนตก'].map(p => (
                <button key={p} onClick={() => setNote(prev => prev ? prev + ', ' + p : p)}
                  className="px-2.5 py-1 rounded-lg text-[13px] cursor-pointer transition-all"
                  style={{border:'1px solid rgba(255,255,255,0.06)',background:'rgba(255,255,255,0.02)',color:'rgba(255,255,255,0.5)'}}
                  onMouseEnter={e=>{e.currentTarget.style.borderColor='rgba(251,191,36,0.2)';e.currentTarget.style.color='white';}}
                  onMouseLeave={e=>{e.currentTarget.style.borderColor='rgba(255,255,255,0.06)';e.currentTarget.style.color='rgba(255,255,255,0.5)';}}>{p}</button>
              ))}
            </div>
            <input value={note} onChange={e => setNote(e.target.value)}
              className="w-full h-11 rounded-xl border border-white/10 bg-white/[0.03] px-3 text-sm text-white outline-none focus:border-yellow-400 transition"
              placeholder="พิมพ์หมายเหตุเพิ่มเติม..." />
          </div>

          <div className="flex gap-2">
            <button onClick={() => setStep(2)} className="flex-1 h-10 rounded-xl border border-white/10 text-neutral-400 text-sm cursor-pointer">← ย้อนกลับ</button>
            <button onClick={() => setStep(4)} className="flex-1 h-10 rounded-xl bg-yellow-400 text-neutral-900 font-bold text-sm cursor-pointer">ยืนยัน →</button>
          </div>
        </div>
      )}

      {/* Step 4: Confirm */}
      {step === 4 && (() => {
        const user = users.find(u => u.id === selectedUser);
        return (
          <div className="space-y-3">
            <p className="text-sm text-neutral-400">ตรวจสอบก่อนจ่ายงาน</p>

            <div className="rounded-2xl p-4" style={{border:'1px solid rgba(255,255,255,0.06)'}}>
              <div className="flex items-center gap-3 mb-3 pb-3" style={{borderBottom:'1px solid rgba(255,255,255,0.04)'}}>
                <div className="w-10 h-10 rounded-xl flex items-center justify-center text-white text-sm font-bold shrink-0" style={{background:'linear-gradient(135deg,#FBBF24,#F59E0B)'}}>{user?.name[0]}</div>
                <div><p className="text-sm font-bold text-white">{user?.name}</p><p className="text-[13px] text-neutral-500">{user?.role} • {user?.vehicle}</p></div>
              </div>
              <div className="mb-3 pb-3" style={{borderBottom:'1px solid rgba(255,255,255,0.04)'}}>
                <p className="text-[13px] text-neutral-500 mb-1">ฟอร์มที่จ่าย ({selectedForms.length})</p>
                {selectedForms.map(fid => {
                  const f = FORMS.find(x=>x.id===fid);
                  return <p key={fid} className="text-sm text-white py-0.5">• {f?.name}</p>;
                })}
              </div>
              <div className="flex gap-4 mb-2">
                <div><p className="text-[13px] text-neutral-500">วันที่</p><p className="text-sm text-sky-400 font-medium">{displayDate}</p></div>
                <div><p className="text-[13px] text-neutral-500">เวลา</p><p className="text-sm text-sky-400 font-medium">{displayTime}</p></div>
                <div><p className="text-[13px] text-neutral-500">แจ้งเตือนก่อน</p><p className="text-sm text-yellow-400 font-medium">{notifBefore === 'ทันที' ? 'ทันที' : notifBefore + ' นาที'}</p></div>
              </div>
              {note && <div className="rounded-xl p-2.5" style={{background:'rgba(251,191,36,0.04)',border:'1px solid rgba(251,191,36,0.1)'}}><p className="text-[13px] text-neutral-500">หมายเหตุ</p><p className="text-sm text-yellow-400">{note}</p></div>}
            </div>

            <div className="flex gap-2">
              <button onClick={() => setStep(3)} className="flex-1 h-10 rounded-xl border border-white/10 text-neutral-400 text-sm cursor-pointer">← แก้ไข</button>
              <button onClick={() => { setDone(true); setShowFW(true); if(window._addRecent) window._addRecent('assign', 'จ่ายงาน → ' + user?.name, 'assignWork'); }}
                className="flex-1 h-10 rounded-xl font-bold text-sm cursor-pointer" style={{background:'linear-gradient(135deg,#FBBF24,#F59E0B)',color:'#1a1a1a'}}>
                ✓ จ่ายงาน
              </button>
            </div>
          </div>
        );
      })()}
    </div>
  );
}

/* ═══════════════════════════════════════════
   PAGE CONTENT
   ═══════════════════════════════════════════ */
function PageContent({ role, pageKey, setupStep, setSetupStep }) {
  const [rTab, setRTab] = useState('overview');
  const [selDim, setSelDim] = useState(null);
  const page = pageMeta[pageKey];
  const kpis = roleKpis[role];
  const isDashboard = pageKey === 'dashboard';

  return (
    <div className="space-y-4">
      {/* ═══ Goal & Reward System — Dashboard ═══ */}
      {isDashboard && (() => {
        const sc = 180;
        const streak = 5;
        const formsDone = 12;
        const levels = [{min:0,name:'เริ่มต้น',icon:'🌱',next:50,title:'ผู้เริ่มต้น'},{min:50,name:'มือใหม่',icon:'⭐',next:120,title:'นักเรียนรู้'},{min:120,name:'ชำนาญ',icon:'🔥',next:200,title:'ผู้ชำนาญการ'},{min:200,name:'เชี่ยวชาญ',icon:'💎',next:300,title:'ผู้เชี่ยวชาญ'},{min:300,name:'เพชร',icon:'👑',next:999,title:'ระดับตำนาน'}];
        const cur = [...levels].reverse().find(l => sc >= l.min) || levels[0];
        const nxt = levels[levels.indexOf(cur) + 1] || cur;
        const pct = nxt.next > cur.min ? Math.round(((sc - cur.min) / (nxt.next - cur.min)) * 100) : 100;
        const rewards = [
          {target:50,name:'คูปองกาแฟ',icon:'☕',cl:'#F59E0B'},
          {target:120,name:'บัตรน้ำมัน 200฿',icon:'⛽',cl:'#60A5FA'},
          {target:200,name:'ส่วนลด พ.ร.บ. 10%',icon:'📋',cl:'#34D399'},
          {target:300,name:'ประกันอุบัติเหตุ',icon:'🛡️',cl:'#A78BFA'},
          {target:500,name:'ทริปท่องเที่ยว',icon:'✈️',cl:'#F87171'},
        ];
        const nextReward = rewards.find(r => sc < r.target);
        const prevReward = [...rewards].reverse().find(r => sc >= r.target);
        const missions = [
          {label:'ทำ ROLLCALL ก่อนงาน',pts:10,done:true},
          {label:'ตรวจความพร้อมรถ',pts:12,done:true},
          {label:'ตรวจเส้นทาง',pts:8,done:false},
          {label:'Check-in ระหว่างทาง',pts:6,done:false},
          {label:'ROLLCALL หลังงาน',pts:8,done:false},
        ];
        const mDone = missions.filter(m=>m.done).length;
        return (
        <div className="space-y-3">
          {/* ── Row 1: ฉายา (ซ้าย) + เป้าหมายถัดไป (ขวา) ── */}
          <div className="flex gap-3">
            {/* ซ้าย: ฉายา + คะแนน */}
            <div className="flex-1 rounded-2xl overflow-hidden" style={{border:'1px solid rgba(251,191,36,0.15)',boxShadow:'0 4px 20px rgba(0,0,0,0.3)'}}>
              <div style={{height:3,background:'linear-gradient(90deg,#FBBF24,#F59E0B,transparent)'}}/>
              <div className="p-4" style={{background:'linear-gradient(135deg,rgba(251,191,36,0.06),transparent)'}}>
                <div className="flex items-center gap-3 mb-3">
                  <div className="w-14 h-14 rounded-2xl flex items-center justify-center text-3xl" style={{background:'linear-gradient(135deg,rgba(251,191,36,0.15),rgba(251,191,36,0.05))'}}>{cur.icon}</div>
                  <div>
                    <p className="text-[13px] text-neutral-500 uppercase tracking-wider">ฉายา</p>
                    <p className="text-lg font-black text-yellow-400 leading-tight">{cur.title}</p>
                    <p className="text-[13px] text-neutral-500">{cur.name} • Level {levels.indexOf(cur)+1}</p>
                  </div>
                </div>
                <div className="flex items-end gap-1 mb-2">
                  <span className="text-3xl font-black text-white leading-none">{sc}</span>
                  <span className="text-sm text-neutral-500 pb-0.5">คะแนน</span>
                </div>
                <div className="h-2 rounded-full bg-neutral-800 overflow-hidden mb-1">
                  <div className="h-full rounded-full" style={{width:pct+'%',background:'linear-gradient(90deg,#FBBF24,#34D399)',transition:'width 0.5s'}}/>
                </div>
                <p className="text-[13px] text-neutral-600">{nxt !== cur ? 'อีก '+(nxt.next-sc)+' ถึง '+nxt.icon+' '+nxt.title : '🏆 สูงสุดแล้ว!'}</p>
                {/* Mini stats */}
                <div className="flex gap-2 mt-3 pt-3" style={{borderTop:'1px solid rgba(255,255,255,0.04)'}}>
                  <div className="flex-1 text-center"><p className="text-base font-bold text-emerald-400">{formsDone}</p><p className="text-[13px] text-neutral-600">ฟอร์ม</p></div>
                  <div className="flex-1 text-center"><p className="text-base font-bold text-red-400">{streak}🔥</p><p className="text-[13px] text-neutral-600">streak</p></div>
                  <div className="flex-1 text-center"><p className="text-base font-bold text-purple-400">3</p><p className="text-[13px] text-neutral-600">เหรียญ</p></div>
                </div>
              </div>
            </div>

            {/* ขวา: เป้าหมาย + รางวัลถัดไป */}
            <div className="w-44 shrink-0 flex flex-col gap-3">
              {/* รางวัลถัดไป */}
              {nextReward && (
                <div className="flex-1 rounded-2xl overflow-hidden" style={{border:'1px solid '+nextReward.cl+'25',boxShadow:'0 4px 20px rgba(0,0,0,0.3)'}}>
                  <div style={{height:3,background:'linear-gradient(90deg,'+nextReward.cl+',transparent)'}}/>
                  <div className="p-3 h-full flex flex-col" style={{background:nextReward.cl+'08'}}>
                    <p className="text-[13px] text-neutral-500 mb-1">เป้าถัดไป</p>
                    <div className="text-center flex-1 flex flex-col items-center justify-center">
                      <span className="text-3xl mb-1">{nextReward.icon}</span>
                      <p className="text-sm font-bold text-white">{nextReward.name}</p>
                      <div className="w-full h-2 rounded-full bg-neutral-800 overflow-hidden mt-2 mb-1">
                        <div className="h-full rounded-full" style={{width:Math.round((sc/nextReward.target)*100)+'%',background:nextReward.cl}}/>
                      </div>
                      <p className="text-[13px] font-bold" style={{color:nextReward.cl}}>{sc}/{nextReward.target}</p>
                    </div>
                    <p className="text-[13px] text-neutral-600 text-center">อีก {nextReward.target-sc} คะแนน</p>
                  </div>
                </div>
              )}
              {/* รางวัลที่แลกได้ */}
              {prevReward && (
                <div className="rounded-xl p-2.5 flex items-center gap-2" style={{background:'rgba(52,211,153,0.06)',border:'1px solid rgba(52,211,153,0.12)'}}>
                  <span className="text-lg">{prevReward.icon}</span>
                  <div className="flex-1 min-w-0">
                    <p className="text-[13px] text-emerald-400 font-bold truncate">{prevReward.name}</p>
                    <p className="text-[13px] text-neutral-500">แลกได้!</p>
                  </div>
                </div>
              )}
            </div>
          </div>

          {/* ── Row 2: ภารกิจวันนี้ ── */}
          <div className="rounded-2xl overflow-hidden" style={{border:'1px solid rgba(255,255,255,0.06)',boxShadow:'0 4px 20px rgba(0,0,0,0.3)'}}>
            <div className="px-4 py-2.5 flex items-center justify-between" style={{background:'linear-gradient(135deg,#FBBF24,#F59E0B)'}}>
              <div className="flex items-center gap-2">
                <Icon type="clipboard" className="h-4 w-4" style={{color:'#1a1a1a'}}/>
                <p style={{fontSize:14,fontWeight:800,color:'#1a1a1a',margin:0}}>ภารกิจวันนี้</p>
              </div>
              <div className="flex items-center gap-2">
                <span style={{fontSize:13,fontWeight:800,color:'#1a1a1a'}}>{mDone}/{missions.length}</span>
                <div className="w-16 h-1.5 rounded-full overflow-hidden" style={{background:'rgba(0,0,0,0.1)'}}><div className="h-full rounded-full" style={{width:(mDone/missions.length*100)+'%',background:'#1a1a1a'}}/></div>
              </div>
            </div>
            <div className="p-2">
              {[...missions].sort((a,b) => a.done === b.done ? 0 : a.done ? 1 : -1).map((m,i) => {
                const undoneIdx = missions.filter(x=>!x.done).indexOf(m);
                return (
                <div key={m.label} className="flex items-center gap-2.5 px-3 py-2 rounded-xl transition-all duration-150"
                  style={{opacity:m.done?0.5:1,borderBottom:!m.done&&i<missions.filter(x=>!x.done).length-1?'1px solid rgba(255,255,255,0.03)':'none'}}
                  onMouseEnter={e=>{if(!m.done)e.currentTarget.style.background='rgba(251,191,36,0.04)';e.currentTarget.style.paddingLeft='16px';}}
                  onMouseLeave={e=>{e.currentTarget.style.background='transparent';e.currentTarget.style.paddingLeft='12px';}}>
                  <div className="w-6 h-6 rounded-lg flex items-center justify-center shrink-0" style={{background:m.done?'rgba(52,211,153,0.15)':'rgba(251,191,36,0.15)'}}>
                    {m.done ? <span className="text-emerald-400 text-[13px]">✓</span> : <span className="text-[13px] font-bold text-yellow-400">{undoneIdx+1}</span>}
                  </div>
                  <p className={cn('text-sm flex-1',m.done?'text-neutral-600 line-through':'text-white')}>{m.label}</p>
                  <span className="text-[13px] font-bold" style={{color:m.done?'#34D399':'#FBBF24'}}>+{m.pts}</span>
                </div>
                );
              })}
            </div>
          </div>

          {/* ── Row 3: Reward roadmap compact ── */}
          <div className="flex items-center gap-1 px-2">
            {rewards.map((r,i) => {
              const done = sc >= r.target;
              const active = nextReward && r.target === nextReward.target;
              return (
                <React.Fragment key={i}>
                  <div className="flex flex-col items-center" style={{flex:'0 0 auto'}}>
                    <div className="w-8 h-8 rounded-lg flex items-center justify-center text-sm transition-transform" style={{background:done?r.cl+'20':active?r.cl+'10':'rgba(255,255,255,0.03)',border:active?'2px solid '+r.cl:'none',opacity:done?1:active?1:0.35,transform:active?'scale(1.15)':'scale(1)'}}>{r.icon}</div>
                    <p className="text-[13px] mt-0.5" style={{color:done?r.cl:active?r.cl:'rgba(255,255,255,0.3)'}}>{r.target}</p>
                  </div>
                  {i < rewards.length - 1 && <div className="flex-1 h-0.5 rounded" style={{background:sc>=rewards[i+1].target?'#34D399':done?'linear-gradient(90deg,'+r.cl+',rgba(255,255,255,0.06))':'rgba(255,255,255,0.04)',minWidth:8}}/>}
                </React.Fragment>
              );
            })}
          </div>
        </div>
        );
      })()}


      {/* Page header — yellow banner */}
      <div className="rounded-2xl overflow-hidden">
        <div className="p-4 lg:p-5" style={{background:'linear-gradient(135deg,#FBBF24,#F59E0B)'}}>
          <div className="flex items-center justify-between mb-2">
            <div className="flex items-center gap-2.5">
              <div className="h-9 w-9 rounded-xl flex items-center justify-center" style={{background:'rgba(0,0,0,0.1)'}}>
                <Icon type={menuCatalog[pageKey].icon} className="h-4 w-4" style={{color:'#1a1a1a'}} />
              </div>
              <span style={{fontSize:13,fontWeight:700,color:'rgba(0,0,0,0.5)',textTransform:'uppercase',letterSpacing:1}}>{menuCatalog[pageKey].label}</span>
            </div>
            <span style={{fontSize:13,color:'rgba(0,0,0,0.4)'}}>{new Date().toLocaleDateString('th-TH',{day:'numeric',month:'short',year:'numeric'})}</span>
          </div>
          <h2 style={{fontSize:22,fontWeight:800,color:'#1a1a1a',margin:0,lineHeight:1.3}}>{page.hero}</h2>
          <p style={{fontSize:13,color:'rgba(0,0,0,0.5)',marginTop:4,lineHeight:1.5}}>{page.description}</p>
        </div>
      </div>

      {/* Dashboard extras */}


      {/* Quick Actions with yellow header */}
      {isDashboard && (
        <div className="rounded-2xl overflow-hidden" style={{boxShadow:'0 4px 20px rgba(0,0,0,0.3)',border:'1px solid rgba(255,255,255,0.06)'}}>
          <div className="px-4 py-2.5 flex items-center gap-2" style={{background:'linear-gradient(135deg,#FBBF24,#F59E0B)'}}>
            <Icon type="settings" className="h-4 w-4" style={{color:'#1a1a1a'}}/>
            <p style={{fontSize:14,fontWeight:800,color:'#1a1a1a',margin:0}}>ทางลัด</p>
          </div>
          <div className="p-3" style={{background:'linear-gradient(180deg,rgba(251,191,36,0.03),transparent)'}}>
            <QuickActions items={page.quick} />
          </div>
        </div>
      )}

      {/* ═══ Daily Operations — TSM ═══ */}
      {pageKey === 'dailyOps' && (
        <div className="space-y-3">
          {/* Overview stats */}
          <div className="grid grid-cols-2 xl:grid-cols-4 gap-2">
            {[
              {l:'รถวิ่งวันนี้',v:'6/8',sub:'คัน',cl:'#60A5FA',icon:'car'},
              {l:'ผู้ขับปฏิบัติงาน',v:'5/6',sub:'คน',cl:'#34D399',icon:'users'},
              {l:'ROLLCALL ครบ',v:'4/5',sub:'คน',cl:'#FBBF24',icon:'clipboard'},
              {l:'เหตุการณ์วันนี้',v:'0',sub:'ไม่มี',cl:'#34D399',icon:'shield'},
            ].map((s,i) => (
              <div key={i} className="rounded-2xl p-3" style={{border:'1px solid rgba(255,255,255,0.06)',background:'linear-gradient(135deg,rgba(255,255,255,0.03),transparent)'}}>
                <div className="flex items-center justify-between mb-1">
                  <p className="text-[13px] text-neutral-500">{s.l}</p>
                  <div className="w-6 h-6 rounded-lg flex items-center justify-center" style={{background:s.cl+'15'}}><Icon type={s.icon} className="h-3 w-3" style={{color:s.cl}}/></div>
                </div>
                <p className="text-2xl font-black" style={{color:s.cl}}>{s.v}</p>
                <p className="text-[13px] text-neutral-600">{s.sub}</p>
              </div>
            ))}
          </div>

          {/* ── ต้องดำเนินการ (ด่วน) ── */}
          <div className="rounded-2xl overflow-hidden" style={{border:'1px solid rgba(248,113,113,0.15)'}}>
            <div className="px-4 py-2.5 flex items-center gap-2" style={{background:'linear-gradient(135deg,#FBBF24,#F59E0B)'}}>
              <Icon type="incident" className="h-4 w-4" style={{color:'#1a1a1a'}}/>
              <p style={{fontSize:14,fontWeight:800,color:'#1a1a1a',margin:0}}>ต้องดำเนินการ</p>
              <span style={{fontSize:13,fontWeight:700,color:'rgba(0,0,0,0.4)',marginLeft:'auto'}}>3 รายการ</span>
            </div>
            <div className="p-2" style={{background:'rgba(248,113,113,0.03)'}}>
              {[
                {text:'ประเสริฐ — ยังไม่ทำ ROLLCALL ก่อนงาน',time:'เกิน 30 นาที',cl:'#F87171',action:'แจ้งเตือน'},
                {text:'รถ บบ-7765 — พ.ร.บ. หมดอายุแล้ว',time:'เกิน 14 วัน',cl:'#F87171',action:'ดำเนินการ'},
                {text:'วิชัย — ยังไม่ผ่านอบรมขับรถปลอดภัย',time:'ห้ามขับจนกว่าจะผ่าน',cl:'#F87171',action:'จัดอบรม'},
              ].map((a,i) => (
                <div key={i} className="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 cursor-pointer"
                  onMouseEnter={e=>{e.currentTarget.style.background='rgba(248,113,113,0.05)';e.currentTarget.style.paddingLeft='16px';}}
                  onMouseLeave={e=>{e.currentTarget.style.background='transparent';e.currentTarget.style.paddingLeft='12px';}}>
                  <div className="w-2 h-2 rounded-full shrink-0" style={{background:a.cl}}/>
                  <div className="flex-1 min-w-0">
                    <p className="text-sm text-white">{a.text}</p>
                    <p className="text-[13px] text-red-400">{a.time}</p>
                  </div>
                  <button className="text-[13px] font-bold px-2.5 py-1 rounded-lg cursor-pointer shrink-0" style={{background:a.cl+'15',color:a.cl}}>{a.action}</button>
                </div>
              ))}
            </div>
          </div>

          {/* ── งานที่รับจากเจ้าของกิจการ ── */}
          <div className="rounded-2xl overflow-hidden" style={{border:'1px solid rgba(167,139,250,0.15)',boxShadow:'0 4px 20px rgba(0,0,0,0.3)'}}>
            <div className="px-4 py-2.5 flex items-center gap-2" style={{background:'linear-gradient(135deg,#FBBF24,#F59E0B)'}}>
              <Icon type="send" className="h-4 w-4" style={{color:'#1a1a1a'}}/>
              <p style={{fontSize:14,fontWeight:800,color:'#1a1a1a',margin:0}}>งานจากเจ้าของกิจการ</p>
              <span style={{fontSize:13,fontWeight:700,color:'rgba(0,0,0,0.4)',marginLeft:'auto'}}>2 รายการ</span>
            </div>
            <div className="p-2">
              {[
                {task:'ตรวจสภาพรถทุกคัน + ROLLCALL',from:'นภา บริหาร',date:'31 มี.ค.',note:'ลูกค้ารายใหญ่มารับของ',status:'รับแล้ว',cl:'#A78BFA'},
                {task:'ต่อ พ.ร.บ. รถ บบ-7765',from:'นภา บริหาร',date:'10 เม.ย.',note:'หมดอายุ 14 วัน ด่วน!',status:'รับแล้ว',cl:'#F87171'},
              ].map((t,i) => (
                <div key={i} className="flex items-center gap-3 px-3 py-2.5 rounded-xl mb-1" style={{background:'rgba(167,139,250,0.04)',border:'1px solid rgba(167,139,250,0.08)'}}>
                  <div className="w-8 h-8 rounded-xl flex items-center justify-center text-[13px] font-bold text-white shrink-0" style={{background:'linear-gradient(135deg,#60A5FA,#3B82F6)'}}>{t.from[0]}</div>
                  <div className="flex-1 min-w-0">
                    <p className="text-sm text-white font-medium">{t.task}</p>
                    <p className="text-[13px] text-neutral-500">{t.from} • {t.date} {t.note && '• 💬 '+t.note}</p>
                  </div>
                  <span className="text-[13px] font-bold px-2 py-0.5 rounded-lg shrink-0" style={{background:t.cl+'15',color:t.cl}}>{t.status}</span>
                </div>
              ))}
            </div>
          </div>

                    {/* ── Checklist งาน TSM วันนี้ ── */}
          <div className="rounded-2xl overflow-hidden" style={{border:'1px solid rgba(255,255,255,0.06)'}}>
            <div className="px-4 py-2.5 flex items-center gap-2" style={{background:'linear-gradient(135deg,#FBBF24,#F59E0B)'}}>
              <Icon type="clipboard" className="h-4 w-4" style={{color:'#1a1a1a'}}/>
              <p style={{fontSize:14,fontWeight:800,color:'#1a1a1a',margin:0}}>Checklist งาน TSM วันนี้</p>
              <span style={{fontSize:13,fontWeight:700,color:'rgba(0,0,0,0.4)',marginLeft:'auto'}}>6/11</span>
            </div>
            <div className="p-2">
              {[
                {cat:'ก่อนออกเดินทาง',items:[
                  {l:'ตรวจ ROLLCALL ก่อนงาน (5 คน)',done:true,pts:'+10'},
                  {l:'ตรวจความพร้อมรถ (6 คัน)',done:true,pts:'+12'},
                  {l:'จ่ายงานประจำวัน',done:true,pts:'+5'},
                ]},
                {cat:'ระหว่างปฏิบัติงาน',items:[
                  {l:'ติดตาม GPS Tracking',done:true,pts:'auto'},
                  {l:'ตรวจ ROLLCALL ระหว่างงาน',done:true,pts:'+8'},
                  {l:'ตรวจสอบปัญหาระหว่างทาง',done:true,pts:'+3'},
                ]},
                {cat:'หลังเลิกงาน',items:[
                  {l:'ตรวจ ROLLCALL หลังงาน (5 คน)',done:false,pts:'+8'},
                  {l:'ตรวจ Log Book สรุปเที่ยว',done:false,pts:'+5'},
                  {l:'บันทึกเหตุการณ์ (ถ้ามี)',done:false,pts:'+3'},
                ]},
                {cat:'งานบริหาร',items:[
                  {l:'ตรวจเอกสารหมดอายุ',done:false,pts:'+3'},
                  {l:'สรุปรายงานประจำวัน',done:false,pts:'+5'},
                ]},
              ].map((g,gi) => (
                <div key={gi} className="mb-2">
                  <p className="text-[13px] font-bold text-neutral-500 px-3 py-1.5 uppercase tracking-wider">{g.cat}</p>
                  {g.items.map((item,ii) => (
                    <div key={ii} className="flex items-center gap-2.5 px-3 py-2 rounded-xl cursor-pointer transition-all duration-150"
                      style={{opacity:item.done?0.6:1}}
                      onMouseEnter={e=>{if(!item.done)e.currentTarget.style.background='rgba(251,191,36,0.04)';}}
                      onMouseLeave={e=>{e.currentTarget.style.background='transparent';}}>
                      <div className="w-6 h-6 rounded-lg flex items-center justify-center shrink-0" style={{background:item.done?'rgba(52,211,153,0.15)':'rgba(255,255,255,0.04)'}}>
                        {item.done ? <span className="text-emerald-400 text-[13px]">✓</span> : <div className="w-2 h-2 rounded-full" style={{background:'rgba(255,255,255,0.15)'}}/>}
                      </div>
                      <p className={`text-sm flex-1 ${item.done?'text-neutral-600 line-through':'text-white'}`}>{item.l}</p>
                      <span className="text-[13px] font-bold" style={{color:item.done?'#34D399':'#FBBF24'}}>{item.pts}</span>
                    </div>
                  ))}
                </div>
              ))}
            </div>
          </div>

          {/* ── GPS Map ── */}
          <GPSMap mode="all" />
        </div>
      )}

            {pageKey === 'knowledge' && (
        <div className="space-y-4">
          {/* ═══ Learning Resources — ด้านบนสุด ═══ */}
          <div className="grid grid-cols-2 sm:grid-cols-4 gap-2">
            {[
              {t:'คู่มือ TSMC',d:'วิธีใช้ระบบ ทำฟอร์ม ส่งรายงาน',c:'12 บทเรียน',cl:'#60A5FA',icon:'file'},
              {t:'ประกาศกรมฯ',d:'ประกาศกรมขนส่งฯ พ.ศ. 2564',c:'3 ฉบับ',cl:'#FBBF24',icon:'shield'},
              {t:'วิดีโอสาธิต',d:'สอนใช้งานทีละขั้นตอน',c:'8 คลิป',cl:'#34D399',icon:'training'},
              {t:'เคล็ดลับใช้งาน',d:'GPS auto-fill, กดเลือก, ทำทีละข้อ',c:'4 เคล็ดลับ',cl:'#A78BFA',icon:'chart'},
            ].map((k,i) => (
              <div key={i} className="rounded-2xl p-3 cursor-pointer transition-all duration-200"
                style={{border:'1px solid rgba(255,255,255,0.06)',boxShadow:'0 4px 16px rgba(0,0,0,0.2)'}}
                onMouseEnter={e=>{e.currentTarget.style.borderColor=k.cl+'30';e.currentTarget.style.transform='translateY(-2px)';e.currentTarget.style.boxShadow='0 8px 24px rgba(0,0,0,0.3)';}}
                onMouseLeave={e=>{e.currentTarget.style.borderColor='rgba(255,255,255,0.06)';e.currentTarget.style.transform='';e.currentTarget.style.boxShadow='0 4px 16px rgba(0,0,0,0.2)';}}>
                <div className="w-10 h-10 rounded-xl flex items-center justify-center mb-2" style={{background:k.cl+'15'}}><Icon type={k.icon} className="h-4 w-4" style={{color:k.cl}}/></div>
                <p className="text-sm font-bold text-white">{k.t}</p>
                <p className="text-[13px] text-neutral-500 mt-0.5">{k.d}</p>
                <span className="text-[13px] font-bold mt-1.5 inline-block" style={{color:k.cl}}>{k.c} →</span>
              </div>
            ))}
          </div>

          {/* ═══ Training & Certification Alert ═══ */}
          <div className="rounded-2xl overflow-hidden" style={{border:'1px solid rgba(167,139,250,0.2)'}}>
            <div style={{height:3,background:'linear-gradient(90deg,#A78BFA,#FBBF24,transparent)'}}/>
            <div className="p-4" style={{background:'linear-gradient(135deg,rgba(167,139,250,0.04),transparent)'}}>
              <div className="flex items-center gap-2 mb-3">
                <Icon type="training" className="h-4 w-4 text-purple-400"/>
                <p className="text-sm font-bold text-purple-400">วุฒิบัตร/เกียรติบัตร — สถานะบุคลากร</p>
              </div>
              {[
                {name:'วิชัย ส่งด่วน',role:'ผู้ขับ',cert:'ยังไม่ผ่านอบรม',issued:'—',refresh:'—',left:'—',cl:'#F87171',status:'ต้องอบรม'},
                {name:'ประเสริฐ รถมั่นคง',role:'ผู้ขับ',cert:'ขับรถปลอดภัย',issued:'5 มี.ค. 2568',refresh:'5 มี.ค. 2569',left:'-24 วัน',cl:'#F87171',status:'หมดแล้ว!'},
                {name:'สุรชัย ขับดี',role:'ผู้ขับ',cert:'ขับรถปลอดภัย',issued:'20 มิ.ย. 2568',refresh:'20 มิ.ย. 2569',left:'83 วัน',cl:'#FBBF24',status:'อีก 3 เดือน'},
                {name:'อนันต์ ปลอดภัย',role:'ผู้ขับ',cert:'สินค้าอันตราย',issued:'1 ส.ค. 2568',refresh:'1 ส.ค. 2569',left:'125 วัน',cl:'#34D399',status:'อีก 4 เดือน'},
                {name:'สมชาย ใจดี',role:'TSM',cert:'TSM 18 ชม.',issued:'10 ม.ค. 2567',refresh:'10 ม.ค. 2570',left:'10 เดือน',cl:'#34D399',status:'ปัจจุบัน'},
                {name:'นภา บริหาร',role:'เจ้าของกิจการ',cert:'TSM ทบทวน 3 ชม.',issued:'15 ธ.ค. 2568',refresh:'15 ธ.ค. 2571',left:'2 ปี 9 เดือน',cl:'#34D399',status:'ปัจจุบัน'},
              ].map((p,i) => (
                <div key={i} className="flex items-center gap-3 py-3 cursor-pointer transition-all duration-150"
                  style={{borderBottom:i<5?'1px solid rgba(255,255,255,0.04)':'none'}}
                  onMouseEnter={e=>{e.currentTarget.style.background='rgba(255,255,255,0.02)';e.currentTarget.style.paddingLeft='4px';}}
                  onMouseLeave={e=>{e.currentTarget.style.background='';e.currentTarget.style.paddingLeft='';}}>
                  <div className="w-9 h-9 rounded-xl flex items-center justify-center text-sm font-bold text-white shrink-0" style={{background:'linear-gradient(135deg,#A78BFA,#7C3AED)'}}>{p.name[0]}</div>
                  <div className="flex-1 min-w-0">
                    <div className="flex items-center gap-2">
                      <p className="text-sm text-white font-medium">{p.name}</p>
                      <span className="text-[13px] px-1.5 py-0.5 rounded" style={{background:'rgba(255,255,255,0.04)',color:'rgba(255,255,255,0.4)'}}>{p.role}</span>
                    </div>
                    <p className="text-[13px] text-neutral-500">{p.cert} {p.issued !== '—' ? '• ออกให้ '+p.issued : ''}</p>
                  </div>
                  <div className="text-right shrink-0">
                    <span className="text-[13px] font-bold px-2 py-1 rounded-lg" style={{background:p.cl+'15',color:p.cl}}>{p.status}</span>
                    {p.refresh !== '—' && <p className="text-[13px] text-neutral-600 mt-0.5">refresh {p.refresh}</p>}
                  </div>
                </div>
              ))}
            </div>
          </div>

          {/* ═══ DLT Training Requirements ═══ */}
          <div className="rounded-2xl overflow-hidden" style={{border:'1px solid rgba(251,191,36,0.15)'}}>
            <div style={{height:3,background:'linear-gradient(90deg,#FBBF24,transparent)'}}/>
            <div className="p-4" style={{background:'linear-gradient(135deg,rgba(251,191,36,0.04),transparent)'}}>
              <div className="flex items-center gap-2 mb-3">
                <Icon type="shield" className="h-4 w-4 text-yellow-400"/>
                <p className="text-sm font-bold text-yellow-400">หลักสูตรตามกรมการขนส่งทางบก</p>
              </div>
              <div className="space-y-2">
                {[
                  {course:'TSM บุคคลทั่วไป',hrs:'18 ชม.',who:'บุคคลทั่วไปที่จะเป็น TSM',refresh:'3 ปี (ทบทวน 3 ชม.)',icon:'shield',cl:'#FBBF24'},
                  {course:'TSM จป.วิชาชีพ',hrs:'6 ชม.',who:'เจ้าหน้าที่ความปลอดภัยวิชาชีพ',refresh:'3 ปี (ทบทวน 3 ชม.)',icon:'shield',cl:'#FBBF24'},
                  {course:'TSM ผู้มีประสบการณ์ 5 ปี',hrs:'6 ชม.',who:'ผู้มีประสบการณ์ขนส่ง ≥ 5 ปี',refresh:'3 ปี (ทบทวน 3 ชม.)',icon:'shield',cl:'#FBBF24'},
                  {course:'ขับรถปลอดภัย',hrs:'6 ชม.',who:'ผู้ขับรถทุกคน',refresh:'ทุก 1 ปี',icon:'truck',cl:'#60A5FA'},
                  {course:'สินค้าอันตราย',hrs:'12 ชม.',who:'ผู้ขับรถบรรทุกสินค้าอันตราย',refresh:'ทุก 2 ปี',icon:'incident',cl:'#F87171'},
                ].map((c,i) => (
                  <div key={i} className="rounded-xl p-3 flex items-center gap-3" style={{background:'rgba(255,255,255,0.02)',border:'1px solid rgba(255,255,255,0.04)'}}>
                    <div className="w-9 h-9 rounded-xl flex items-center justify-center shrink-0" style={{background:c.cl+'15'}}><Icon type={c.icon} className="h-4 w-4" style={{color:c.cl}}/></div>
                    <div className="flex-1 min-w-0">
                      <p className="text-sm text-white font-medium">{c.course} <span className="text-yellow-400 font-bold">{c.hrs}</span></p>
                      <p className="text-[13px] text-neutral-500">{c.who} • ทบทวน: {c.refresh}</p>
                    </div>
                  </div>
                ))}
              </div>
            </div>
          </div>

          {/* ═══ Upcoming Training Action ═══ */}
          <div className="rounded-2xl overflow-hidden" style={{border:'1px solid rgba(52,211,153,0.15)'}}>
            <div style={{height:3,background:'linear-gradient(90deg,#34D399,transparent)'}}/>
            <div className="p-4" style={{background:'linear-gradient(135deg,rgba(52,211,153,0.04),transparent)'}}>
              <div className="flex items-center gap-2 mb-3">
                <Icon type="training" className="h-4 w-4 text-emerald-400"/>
                <p className="text-sm font-bold text-emerald-400">จัดอบรม — แนะนำดำเนินการ</p>
              </div>
              {[
                {action:'จัดอบรม "ขับรถปลอดภัย" ทบทวน',who:'ประเสริฐ (หมดแล้ว) + สุรชัย (อีก 3 เดือน)',count:2,urgency:'ด่วน!',cl:'#F87171'},
                {action:'จัดอบรม "ขับรถปลอดภัย" ครั้งแรก',who:'วิชัย ส่งด่วน (ยังไม่ผ่านอบรม)',count:1,urgency:'ต้องทำก่อนขับ',cl:'#F87171'},
                {action:'TSM ทบทวน 3 ชม. ครั้งถัดไป',who:'สมชาย ใจดี — refresh ม.ค. 2570',count:1,urgency:'วางแผนล่วงหน้า',cl:'#FBBF24'},
              ].map((a,i) => (
                <div key={i} className="flex items-center gap-3 py-3" style={{borderBottom:i<2?'1px solid rgba(255,255,255,0.04)':'none'}}>
                  <div className="w-8 h-8 rounded-lg flex items-center justify-center" style={{background:a.cl+'15'}}><Icon type="training" className="h-3.5 w-3.5" style={{color:a.cl}}/></div>
                  <div className="flex-1 min-w-0">
                    <p className="text-sm text-white font-medium">{a.action}</p>
                    <p className="text-[13px] text-neutral-500">{a.who}</p>
                  </div>
                  <button className="text-[13px] font-bold px-2.5 py-1.5 rounded-lg cursor-pointer shrink-0 transition-all" style={{background:a.cl+'15',color:a.cl}}
                    onMouseEnter={e=>{e.currentTarget.style.transform='translateY(-1px)';}} onMouseLeave={e=>{e.currentTarget.style.transform='';}}>
                    จัดอบรม ({a.count} คน)
                  </button>
                </div>
              ))}
            </div>
          </div>


        </div>
      )}

      {/* Form List */}
      {(pageKey === 'documentsForms' || pageKey === 'myForms') && <FormListView />}

      {pageKey === 'orgData' && <OrgDataView setupStep={setupStep} setSetupStep={setSetupStep} />}

      {pageKey === 'assignWork' && <AssignWorkView role={role} onNavigate={(page) => { if(window._setPageKey) window._setPageKey(page); }} />}

      {/* ═══ Reports (TSM + Owner) ═══ */}
      {pageKey === 'reports' && (() => {
        return (
        <div className="space-y-3">
          <div className="flex gap-1 p-1 rounded-2xl" style={{background:'#0d1a2e',border:'1px solid rgba(255,255,255,0.06)'}}>
            {[{id:'overview',l:'ภาพรวม'},{id:'dlt',l:'ส่งกรมฯ'},{id:'safety',l:'5 ด้าน'},{id:'people',l:'บุคลากร'},{id:'fleet',l:'รถ/เอกสาร'}].map(t => (
              <button key={t.id} onClick={() => setRTab(t.id)} className="flex-1 py-2 rounded-xl text-[13px] font-bold cursor-pointer transition-all"
                style={{background:rTab===t.id?'linear-gradient(135deg,#FBBF24,#F59E0B)':'transparent',color:rTab===t.id?'#1a1a1a':'rgba(255,255,255,0.4)'}}>{t.l}</button>
            ))}
          </div>
          {rTab === 'overview' && (<div className="space-y-3">
            {/* KPI row */}
            <div className="grid grid-cols-2 xl:grid-cols-4 gap-2">
              {[{l:'อุบัติเหตุ',v:'0',s:'Zero Accident!',cl:'#34D399',icon:'shield'},{l:'ฟอร์มทำแล้ว',v:'142',s:'ไตรมาสนี้',cl:'#FBBF24',icon:'check'},{l:'ระยะทางรวม',v:'12,480',s:'km ปลอดภัย',cl:'#60A5FA',icon:'route'},{l:'คะแนนความปลอดภัย',v:'90',s:'/100 คะแนน',cl:'#A78BFA',icon:'chart'}].map((m,i) => (
                <div key={i} className="rounded-2xl p-3" style={{border:'1px solid rgba(255,255,255,0.06)',boxShadow:'0 4px 16px rgba(0,0,0,0.2)',background:i===0?'rgba(52,211,153,0.06)':'rgba(255,255,255,0.02)'}}>
                  <div className="flex items-center justify-between mb-1"><p className="text-[13px] text-neutral-500">{m.l}</p><Icon type={m.icon} className="h-3.5 w-3.5" style={{color:m.cl}}/></div>
                  <p className="text-2xl font-black" style={{color:m.cl}}>{m.v}</p>
                  <p className="text-[13px] text-neutral-600">{m.s}</p>
                </div>
              ))}
            </div>

            {/* ═══ Chapter 1: ก่อนออกเดินทาง ═══ */}
            <div className="rounded-2xl overflow-hidden" style={{boxShadow:'0 4px 20px rgba(0,0,0,0.3)',border:'1px solid rgba(255,255,255,0.06)'}}>
              <div className="px-4 py-2.5 flex items-center gap-2" style={{background:'linear-gradient(135deg,#FBBF24,#F59E0B)'}}>
                <Icon type="clipboard" className="h-4 w-4" style={{color:'#1a1a1a'}}/>
                <p style={{fontSize:14,fontWeight:800,color:'#1a1a1a',margin:0}}>บทที่ 1: ก่อนออกเดินทาง</p>
              </div>
              <div className="p-4">
                <div className="grid grid-cols-3 gap-2 mb-3">
                  <div className="rounded-xl p-2.5 text-center" style={{background:'rgba(255,255,255,0.03)',border:'1px solid rgba(255,255,255,0.05)'}}><p className="text-lg font-black text-sky-400">48</p><p className="text-[13px] text-neutral-500">ตรวจรถ (ครั้ง)</p></div>
                  <div className="rounded-xl p-2.5 text-center" style={{background:'rgba(255,255,255,0.03)',border:'1px solid rgba(255,255,255,0.05)'}}><p className="text-lg font-black text-emerald-400">96%</p><p className="text-[13px] text-neutral-500">ROLLCALL ผ่าน</p></div>
                  <div className="rounded-xl p-2.5 text-center" style={{background:'rgba(255,255,255,0.03)',border:'1px solid rgba(255,255,255,0.05)'}}><p className="text-lg font-black text-yellow-400">12</p><p className="text-[13px] text-neutral-500">ปัญหาจับได้</p></div>
                </div>
                <div className="rounded-xl p-3 flex items-center gap-2" style={{background:'rgba(96,165,250,0.05)',border:'1px solid rgba(96,165,250,0.1)'}}>
                  <span className="text-base">🔍</span>
                  <p className="text-[13px] text-neutral-400">ตรวจรถก่อนออก <span className="text-sky-400 font-bold">จับปัญหา 12 จุด</span> ก่อนขึ้นถนน — ยาง 5, เบรก 4, ไฟสัญญาณ 3 <span className="text-emerald-400">แก้ไขครบก่อนออกเดินทาง</span></p>
                </div>
              </div>
            </div>

            {/* ═══ Chapter 2: ระหว่างเดินทาง ═══ */}
            <div className="rounded-2xl overflow-hidden" style={{boxShadow:'0 4px 20px rgba(0,0,0,0.3)',border:'1px solid rgba(255,255,255,0.06)'}}>
              <div className="px-4 py-2.5 flex items-center gap-2" style={{background:'linear-gradient(135deg,#FBBF24,#F59E0B)'}}>
                <Icon type="route" className="h-4 w-4" style={{color:'#1a1a1a'}}/>
                <p style={{fontSize:14,fontWeight:800,color:'#1a1a1a',margin:0}}>บทที่ 2: ระหว่างเดินทาง — GPS Tracking 12,480 km</p>
              </div>
              <div className="p-4">
                <div className="flex items-end gap-1.5 h-24 mb-3">
                  {[{h:'06:00',v:0},{h:'08:00',v:72},{h:'10:00',v:81},{h:'12:00',v:45},{h:'14:00',v:78},{h:'16:00',v:76},{h:'18:00',v:68}].map((b,i) => (
                    <div key={i} className="flex-1 flex flex-col items-center gap-0.5">
                      <span className="text-[13px] font-bold" style={{color:b.v>85?'#F87171':b.v>0?'#60A5FA':'transparent'}}>{b.v || ''}</span>
                      <div className="w-full rounded-t-md" style={{height:Math.max(2,(b.v/90*100))+'%',background:b.v>85?'#F87171':b.v>0?'linear-gradient(180deg,#60A5FA,#3B82F6)':'rgba(255,255,255,0.03)'}}/>
                      <span className="text-[13px] text-neutral-600">{b.h}</span>
                    </div>
                  ))}
                </div>
                <div className="flex gap-3 text-[13px] text-neutral-500 mb-3">
                  <span className="flex items-center gap-1"><div className="w-2 h-2 rounded-sm" style={{background:'#60A5FA'}}/> ความเร็วเฉลี่ย</span>
                  <span className="flex items-center gap-1"><div className="w-2 h-2 rounded-sm" style={{background:'#F87171'}}/> เกิน 85 km/h</span>
                  <span className="flex items-center gap-1"><div className="w-2 h-2 rounded-sm" style={{background:'#34D399'}}/> จุดพัก</span>
                  <span>เส้นจำกัด: 90 km/h</span>
                </div>
                <div className="rounded-xl p-3 flex items-center gap-2" style={{background:'rgba(52,211,153,0.05)',border:'1px solid rgba(52,211,153,0.1)'}}>
                  <span className="text-base">✅</span>
                  <p className="text-[13px] text-neutral-400">เฉลี่ย <span className="text-sky-400 font-bold">78 km/h</span> ไม่เกินกำหนด (90) • หยุดพักทุก <span className="text-emerald-400 font-bold">2.5 ชม.</span> (กำหนด 4 ชม.) • <span className="text-emerald-400 font-bold">62 เที่ยว ปลอดภัย 100%</span></p>
                </div>
              </div>
            </div>

            {/* ═══ Chapter 3: ป้องกันความเสี่ยง ═══ */}
            <div className="rounded-2xl overflow-hidden" style={{boxShadow:'0 4px 20px rgba(0,0,0,0.3)',border:'1px solid rgba(255,255,255,0.06)'}}>
              <div className="px-4 py-2.5 flex items-center gap-2" style={{background:'linear-gradient(135deg,#FBBF24,#F59E0B)'}}>
                <Icon type="incident" className="h-4 w-4" style={{color:'#1a1a1a'}}/>
                <p style={{fontSize:14,fontWeight:800,color:'#1a1a1a',margin:0}}>บทที่ 3: ระบบป้องกันความเสี่ยง — จับได้ 3 เหตุการณ์</p>
              </div>
              <div className="p-3">
                {[
                  {title:'แจ้งเตือนเหนื่อยล้า',desc:'สุรชัย ขับต่อเนื่อง 3.8 ชม. ระบบส่งแจ้งเตือนหยุดพัก km 280',status:'แก้ไขแล้ว',cl:'#34D399'},
                  {title:'แจ้งเตือนความเร็ว',desc:'ประเสริฐ เกิน 85 km/h ช่วงก่อสร้างสระบุรี GPS แจ้ง TSM ทันที',status:'แก้ไขแล้ว',cl:'#34D399'},
                  {title:'ถึงรอบบำรุงรักษา',desc:'1กฐ-6852 ครบ 50,000 km นัดเข้าศูนย์วันจันทร์',status:'นัดแล้ว',cl:'#FBBF24'},
                ].map((e,i) => (
                  <div key={i} className="flex items-center gap-3 px-2 py-2.5 rounded-xl mb-1 transition-all cursor-pointer" style={{background:'rgba(255,255,255,0.02)',border:'1px solid rgba(255,255,255,0.04)'}}
                    onMouseEnter={ev=>{ev.currentTarget.style.borderColor='rgba(251,191,36,0.2)';ev.currentTarget.style.paddingLeft='12px';}}
                    onMouseLeave={ev=>{ev.currentTarget.style.borderColor='rgba(255,255,255,0.04)';ev.currentTarget.style.paddingLeft='8px';}}>
                    <div className="w-8 h-8 rounded-xl flex items-center justify-center shrink-0" style={{background:e.cl+'15'}}><Icon type="incident" className="h-3.5 w-3.5" style={{color:e.cl}}/></div>
                    <div className="flex-1 min-w-0"><p className="text-sm text-white font-medium">{e.title}</p><p className="text-[13px] text-neutral-500">{e.desc}</p></div>
                    <span className="text-[13px] font-bold px-2 py-0.5 rounded-lg shrink-0" style={{background:e.cl+'15',color:e.cl}}>{e.status}</span>
                  </div>
                ))}
                <div className="rounded-xl p-3 mt-2 flex items-center gap-2" style={{background:'rgba(251,191,36,0.05)',border:'1px solid rgba(251,191,36,0.1)'}}>
                  <span className="text-base">💡</span>
                  <p className="text-[13px] text-neutral-400">คำแนะนำ: จัดอบรม <span className="text-yellow-400 font-bold">defensive driving</span> สำหรับเส้นทางผ่านสระบุรี เพราะก่อสร้างจะถึง พ.ค. 2569</p>
                </div>
              </div>
            </div>

            {/* ═══ Chapter 4: ทีมร่วมกันทำ ═══ */}
            <div className="rounded-2xl overflow-hidden" style={{boxShadow:'0 4px 20px rgba(0,0,0,0.3)',border:'1px solid rgba(255,255,255,0.06)'}}>
              <div className="px-4 py-2.5 flex items-center gap-2" style={{background:'linear-gradient(135deg,#FBBF24,#F59E0B)'}}>
                <Icon type="users" className="h-4 w-4" style={{color:'#1a1a1a'}}/>
                <p style={{fontSize:14,fontWeight:800,color:'#1a1a1a',margin:0}}>บทที่ 4: ทุกคนร่วมกันทำ</p>
              </div>
              <div className="p-4">
                {[
                  {n:'ประเสริฐ',score:245,pct:98,badge:'Top scorer',cl:'#FBBF24'},
                  {n:'สุรชัย',score:198,pct:95,badge:'สม่ำเสมอ',cl:'#60A5FA'},
                  {n:'อนันต์',score:167,pct:92,badge:'ROLLCALL ดีเยี่ยม',cl:'#60A5FA'},
                  {n:'สมศักดิ์',score:155,pct:88,badge:'',cl:'#60A5FA'},
                  {n:'วิชัย',score:120,pct:78,badge:'ต้องพัฒนา',cl:'#FBBF24'},
                ].map((p,i) => (
                  <div key={i} className="flex items-center gap-3 py-2">
                    <span className="text-sm w-5 text-center" style={{color:i===0?'#FBBF24':i===1?'#C0C0C0':i===2?'#CD7F32':'rgba(255,255,255,0.3)'}}>{i<3?['🥇','🥈','🥉'][i]:(i+1)}</span>
                    <div className="w-7 h-7 rounded-lg flex items-center justify-center text-[13px] font-bold text-white shrink-0" style={{background:'linear-gradient(135deg,#FBBF24,#F59E0B)'}}>{p.n[0]}</div>
                    <div className="flex-1 min-w-0">
                      <div className="flex items-center gap-1.5"><p className="text-sm text-white">{p.n}</p>{p.badge && <span className="text-[13px] px-1.5 py-0.5 rounded" style={{background:p.cl+'15',color:p.cl}}>{p.badge}</span>}</div>
                      <div className="flex items-center gap-2 mt-1"><div className="flex-1 h-1.5 rounded-full bg-neutral-800 overflow-hidden max-w-[120px]"><div className="h-full rounded-full" style={{width:p.pct+'%',background:p.pct>=90?'#34D399':p.pct>=80?'#60A5FA':'#FBBF24'}}/></div><span className="text-[13px] text-neutral-600">{p.pct}%</span></div>
                    </div>
                    <span className="text-sm font-bold" style={{color:'#FBBF24'}}>{p.score}</span>
                  </div>
                ))}
              </div>
            </div>

            {/* ═══ Chapter 5: AI แนะนำ ═══ */}
            <div className="rounded-2xl overflow-hidden" style={{boxShadow:'0 4px 20px rgba(0,0,0,0.3)',border:'1px solid rgba(52,211,153,0.15)'}}>
              <div className="px-4 py-2.5 flex items-center gap-2" style={{background:'linear-gradient(135deg,#FBBF24,#F59E0B)'}}>
                <Icon type="chart" className="h-4 w-4" style={{color:'#1a1a1a'}}/>
                <p style={{fontSize:14,fontWeight:800,color:'#1a1a1a',margin:0}}>บทที่ 5: ระบบแนะนำเพื่อ Zero Accident</p>
              </div>
              <div className="p-3">
                {[
                  {text:'จัดอบรม defensive driving ให้วิชัย (compliance 78%) — เป้า: ยก 90% ใน 30 วัน',cl:'#F87171',icon:'training'},
                  {text:'ต่อ พ.ร.บ. รถ บบ-7765 (หมดแล้ว) + ภาษี 80-4517 (เหลือ 12 วัน) — เลี่ยงค่าปรับ 50,000 บาท',cl:'#F87171',icon:'car'},
                  {text:'เพิ่มจุดพัก 15 นาทีที่สระบุรี เส้นทาง ขอนแก่น-กรุงเทพฯ — ลดความเสี่ยงเหนื่อยล้า 40%',cl:'#FBBF24',icon:'route'},
                  {text:'แชร์ผลงาน Zero Accident เดือนนี้กับทีม — gamification แสดงให้เห็น engagement เพิ่ม 67%',cl:'#34D399',icon:'users'},
                ].map((a,i) => (
                  <div key={i} className="flex items-start gap-3 px-2 py-2.5 rounded-xl mb-1" style={{background:'rgba(255,255,255,0.02)',border:'1px solid rgba(255,255,255,0.04)'}}>
                    <div className="w-7 h-7 rounded-lg flex items-center justify-center shrink-0 mt-0.5" style={{background:a.cl+'15'}}><Icon type={a.icon} className="h-3.5 w-3.5" style={{color:a.cl}}/></div>
                    <p className="text-[13px] text-neutral-300 flex-1">{a.text}</p>
                  </div>
                ))}
              </div>
            </div>

            {/* Export */}
            <div className="grid grid-cols-2 gap-2">
              <button className="h-11 rounded-xl text-[13px] font-bold cursor-pointer flex items-center justify-center gap-2" style={{background:'rgba(239,68,68,0.08)',border:'1px solid rgba(239,68,68,0.12)',color:'#F87171'}}>Export PDF</button>
              <button className="h-11 rounded-xl text-[13px] font-bold cursor-pointer flex items-center justify-center gap-2" style={{background:'rgba(52,211,153,0.08)',border:'1px solid rgba(52,211,153,0.12)',color:'#34D399'}}>Export Excel</button>
            </div>
          </div>)}
          {rTab === 'dlt' && (<div className="rounded-2xl overflow-hidden" style={{boxShadow:'0 4px 20px rgba(0,0,0,0.3)',border:'1px solid rgba(255,255,255,0.06)'}}>
            <div className="px-4 py-2.5" style={{background:'linear-gradient(135deg,#FBBF24,#F59E0B)'}}><p style={{fontSize:14,fontWeight:800,color:'#1a1a1a',margin:0}}>รายงานส่งกรมการขนส่งทางบก</p></div>
            <div className="p-3">{[{q:'Q1',n:'รายงานไตรมาส 1',s:'พร้อมส่ง',cl:'#34D399',p:100},{q:'Q2',n:'รายงานไตรมาส 2',s:'กำลังรวบรวม',cl:'#FBBF24',p:35},{q:'ปี',n:'รายงานอุบัติเหตุ',s:'ไม่มีเหตุ',cl:'#6B7280',p:0},{q:'ปี',n:'วิเคราะห์ 5 ด้าน',s:'กำลังรวบรวม',cl:'#FBBF24',p:20}].map((r,i) => (
              <div key={i} className="rounded-xl p-3 mb-2 cursor-pointer transition-all" style={{background:'rgba(255,255,255,0.02)',border:'1px solid rgba(255,255,255,0.04)',boxShadow:'0 2px 8px rgba(0,0,0,0.15)'}} onMouseEnter={e=>{e.currentTarget.style.transform='translateY(-1px)';}} onMouseLeave={e=>{e.currentTarget.style.transform='';}}>
                <div className="flex items-center justify-between mb-2"><div className="flex items-center gap-2"><span className="text-[13px] font-bold px-2 py-0.5 rounded" style={{background:r.cl+'15',color:r.cl}}>{r.q}</span><p className="text-sm text-white">{r.n}</p></div><span className="text-[13px] font-bold px-2 py-0.5 rounded-lg" style={{background:r.cl+'15',color:r.cl}}>{r.s}</span></div>
                <div className="h-1.5 rounded-full bg-neutral-800 overflow-hidden"><div className="h-full rounded-full" style={{width:r.p+'%',background:r.cl}}/></div>
              </div>))}</div>
          </div>)}
          {rTab === 'safety' && (<div className="rounded-2xl overflow-hidden" style={{boxShadow:'0 4px 20px rgba(0,0,0,0.3)',border:'1px solid rgba(255,255,255,0.06)'}}>
            <div className="px-4 py-2.5" style={{background:'linear-gradient(135deg,#FBBF24,#F59E0B)'}}><p style={{fontSize:14,fontWeight:800,color:'#1a1a1a',margin:0}}>คะแนน 5 ด้าน Q1/2569</p></div>
            <div className="p-3">{[{d:'1. จัดการรถ',sc:92,t:'+5',cl:'#60A5FA'},{d:'2. จัดการผู้ขับ',sc:88,t:'+3',cl:'#34D399'},{d:'3. จัดการเดินรถ',sc:95,t:'+8',cl:'#FBBF24'},{d:'4. บรรทุก/โดยสาร',sc:90,t:'+2',cl:'#A78BFA'},{d:'5. วิเคราะห์/ประเมิน',sc:85,t:'+10',cl:'#F87171'}].map((dim,i) => (
              <div key={i} className="rounded-xl p-3 mb-2 cursor-pointer transition-all" style={{background:'rgba(255,255,255,0.02)',border:'1px solid rgba(255,255,255,0.04)',boxShadow:'0 2px 8px rgba(0,0,0,0.15)'}} onMouseEnter={e=>{e.currentTarget.style.borderColor=dim.cl+'30';e.currentTarget.style.transform='translateX(4px)';}} onMouseLeave={e=>{e.currentTarget.style.borderColor='rgba(255,255,255,0.04)';e.currentTarget.style.transform='';}}>
                <div className="flex items-center justify-between mb-2"><p className="text-sm text-white">{dim.d}</p><div className="flex items-center gap-2"><span className="text-[13px] text-emerald-400 font-bold">{dim.t}</span><span className="text-xl font-black" style={{color:dim.cl}}>{dim.sc}</span></div></div>
                <div className="h-2.5 rounded-full bg-neutral-800 overflow-hidden"><div className="h-full rounded-full" style={{width:dim.sc+'%',background:'linear-gradient(90deg,'+dim.cl+','+dim.cl+'80)'}}/></div>
              </div>))}
              <div className="rounded-xl p-3 mt-2 flex items-center gap-2" style={{background:'rgba(52,211,153,0.05)',border:'1px solid rgba(52,211,153,0.1)'}}><span className="text-base">📊</span><p className="text-[13px] text-neutral-400"><span className="text-emerald-400 font-bold">เฉลี่ย 90/100</span> — สูงกว่าเกณฑ์กรมฯ (70) อยู่ 20 คะแนน</p></div>
            </div>
          </div>)}
          {rTab === 'people' && (<div className="space-y-3">
            {/* Summary stats */}
            <div className="grid grid-cols-4 gap-2">
              {[{l:'ต้องอบรมด่วน',v:'2',cl:'#F87171'},{l:'ใกล้หมดอายุ',v:'1',cl:'#FBBF24'},{l:'ปกติ',v:'4',cl:'#34D399'},{l:'ไม่มีกำหนด',v:'2',cl:'#6B7280'}].map((s,i) => (
                <div key={i} className="rounded-xl p-2.5 text-center" style={{background:s.cl+'08',border:'1px solid '+s.cl+'15'}}>
                  <p className="text-lg font-black" style={{color:s.cl}}>{s.v}</p>
                  <p className="text-[13px] text-neutral-500">{s.l}</p>
                </div>
              ))}
            </div>

            {/* Cert list sorted by urgency */}
            <div className="rounded-2xl overflow-hidden" style={{boxShadow:'0 4px 20px rgba(0,0,0,0.3)',border:'1px solid rgba(255,255,255,0.06)'}}>
              <div className="px-4 py-2.5 flex items-center justify-between" style={{background:'linear-gradient(135deg,#FBBF24,#F59E0B)'}}>
                <p style={{fontSize:14,fontWeight:800,color:'#1a1a1a',margin:0}}>วุฒิบัตร/เกียรติบัตร — สถานะบุคลากร</p>
                <span style={{fontSize:13,color:'rgba(0,0,0,0.4)'}}>เรียงตามความเร่งด่วน</span>
              </div>
              <div className="p-2">
                {[
                  {n:'วิชัย ส่งด่วน',r:'ผู้ขับ',c:'ยังไม่ผ่านอบรม',exp:'—',s:'ต้องอบรม',cl:'#F87171',days:-999,action:'หาหลักสูตร',urgent:true},
                  {n:'ประเสริฐ รถมั่นคง',r:'ผู้ขับ',c:'ขับรถปลอดภัย',exp:'6 มี.ค. 2569',s:'หมดแล้ว 24 วัน!',cl:'#F87171',days:-24,action:'หาหลักสูตร',urgent:true},
                  {n:'สุรชัย ขับดี',r:'ผู้ขับ',c:'ขับรถปลอดภัย',exp:'30 มิ.ย. 2569',s:'อีก 92 วัน',cl:'#FBBF24',days:92,action:'หาหลักสูตร',urgent:false},
                  {n:'อนันต์ ปลอดภัย',r:'ผู้ขับ',c:'สินค้าอันตราย',exp:'15 ส.ค. 2569',s:'อีก 138 วัน',cl:'#34D399',days:138,action:'',urgent:false},
                  {n:'สมศักดิ์ ถนนดี',r:'ผู้ขับ',c:'ขับรถปลอดภัย',exp:'1 ต.ค. 2569',s:'อีก 185 วัน',cl:'#34D399',days:185,action:'',urgent:false},
                  {n:'ธนา เดินทาง',r:'ผู้ขับ',c:'ขับรถปลอดภัย',exp:'15 ธ.ค. 2569',s:'อีก 260 วัน',cl:'#34D399',days:260,action:'',urgent:false},
                  {n:'สมชาย ใจดี',r:'TSM',c:'TSM 18 ชม.',exp:'15 ม.ค. 2570',s:'อีก 291 วัน',cl:'#34D399',days:291,action:'',urgent:false},
                  {n:'สุภาพร ร่วมงาน',r:'เจ้าหน้าที่',c:'—',exp:'—',s:'ไม่มีกำหนด',cl:'#6B7280',days:9999,action:'',urgent:false},
                  {n:'นภา บริหาร',r:'เจ้าของ',c:'—',exp:'—',s:'ไม่มีกำหนด',cl:'#6B7280',days:9999,action:'',urgent:false},
                ].map((p,i) => (
                  <div key={i} className="rounded-xl px-3 py-3 mb-1.5 transition-all duration-150 cursor-pointer"
                    style={{background:p.urgent?p.cl+'06':'rgba(255,255,255,0.01)',borderLeft:p.urgent?'3px solid '+p.cl:'3px solid transparent',border:p.urgent?'1px solid '+p.cl+'20':'1px solid rgba(255,255,255,0.03)'}}
                    onMouseEnter={e=>{e.currentTarget.style.paddingLeft='16px';e.currentTarget.style.background=p.cl+'08';}}
                    onMouseLeave={e=>{e.currentTarget.style.paddingLeft='12px';e.currentTarget.style.background=p.urgent?p.cl+'06':'rgba(255,255,255,0.01)';}}>
                    <div className="flex items-center gap-3">
                      <div className="w-9 h-9 rounded-xl flex items-center justify-center text-[13px] font-bold text-white shrink-0" style={{background:p.cl==='#F87171'?'linear-gradient(135deg,#F87171,#EF4444)':p.cl==='#FBBF24'?'linear-gradient(135deg,#FBBF24,#F59E0B)':p.cl==='#34D399'?'linear-gradient(135deg,#34D399,#10B981)':'linear-gradient(135deg,#6B7280,#4B5563)'}}>{p.n[0]}</div>
                      <div className="flex-1 min-w-0">
                        <div className="flex items-center gap-1.5">
                          <p className="text-sm text-white font-medium">{p.n}</p>
                          <span className="text-[13px] px-1.5 py-0.5 rounded" style={{background:'rgba(255,255,255,0.04)',color:'rgba(255,255,255,0.4)'}}>{p.r}</span>
                        </div>
                        <div className="flex items-center gap-2 mt-1">
                          <span className="text-[13px] text-neutral-500">{p.c}</span>
                          {p.exp !== '—' && <span className="text-[13px] text-neutral-600">• หมด {p.exp}</span>}
                        </div>
                      </div>
                      <div className="flex items-center gap-2 shrink-0">
                        <span className="text-[13px] font-bold px-2 py-1 rounded-lg" style={{background:p.cl+'15',color:p.cl}}>{p.s}</span>
                        {p.action && <button className="text-[13px] font-bold px-2.5 py-1.5 rounded-lg cursor-pointer transition-all flex items-center gap-1" style={{background:'linear-gradient(135deg,#FBBF24,#F59E0B)',color:'#1a1a1a'}}
                          onClick={e=>{e.stopPropagation(); window.open('https://www.iddrives.com','_blank');}}><Icon type="send" className="h-3 w-3" style={{color:'#1a1a1a'}}/> {p.action}</button>}
                      </div>
                    </div>
                  </div>
                ))}
              </div>
            </div>

            {/* หาหลักสูตรอบรม */}
            <div className="rounded-2xl overflow-hidden" style={{boxShadow:'0 4px 20px rgba(0,0,0,0.3)',border:'1px solid rgba(255,255,255,0.06)'}}>
              <div className="px-4 py-2.5" style={{background:'linear-gradient(135deg,#FBBF24,#F59E0B)'}}>
                <p style={{fontSize:14,fontWeight:800,color:'#1a1a1a',margin:0}}>หลักสูตรอบรมแนะนำ</p>
              </div>
              <div className="p-3">
                {[
                  {name:'ขับรถปลอดภัย (ทบทวน)',hrs:'6 ชม.',who:'ประเสริฐ + สุรชัย',count:2,cl:'#F87171',price:'2,500 ฿/คน',provider:'iDDrives • กรมขนส่งฯ'},
                  {name:'ขับรถปลอดภัย (ครั้งแรก)',hrs:'18 ชม.',who:'วิชัย',count:1,cl:'#F87171',price:'4,500 ฿/คน',provider:'iDDrives • สถาบันอบรม'},
                  {name:'ขนส่งสินค้าอันตราย (ทบทวน)',hrs:'6 ชม.',who:'อนันต์',count:1,cl:'#FBBF24',price:'3,000 ฿/คน',provider:'iDDrives • กรมขนส่งฯ'},
                  {name:'TSM ทบทวน',hrs:'3 ชม.',who:'สมชาย',count:1,cl:'#34D399',price:'1,500 ฿/คน',provider:'iDDrives • tsmthai.com'},
                ].map((c,i) => (
                  <div key={i} className="rounded-xl p-3 mb-2 transition-all duration-150 cursor-pointer" style={{background:'rgba(255,255,255,0.02)',border:'1px solid rgba(255,255,255,0.04)',boxShadow:'0 2px 8px rgba(0,0,0,0.15)'}}
                    onMouseEnter={e=>{e.currentTarget.style.transform='translateY(-2px)';e.currentTarget.style.borderColor=c.cl+'30';}}
                    onMouseLeave={e=>{e.currentTarget.style.transform='';e.currentTarget.style.borderColor='rgba(255,255,255,0.04)';}}>
                    <div className="flex items-center justify-between mb-2">
                      <div className="flex items-center gap-2">
                        <div className="w-8 h-8 rounded-xl flex items-center justify-center shrink-0" style={{background:c.cl+'15'}}><Icon type="training" className="h-3.5 w-3.5" style={{color:c.cl}}/></div>
                        <div>
                          <p className="text-sm text-white font-medium">{c.name}</p>
                          <p className="text-[13px] text-neutral-500">{c.hrs} • {c.provider}</p>
                        </div>
                      </div>
                      <span className="text-sm font-bold" style={{color:c.cl}}>{c.price}</span>
                    </div>
                    <div className="flex items-center justify-between">
                      <p className="text-[13px] text-neutral-400">สำหรับ: <span className="text-white font-medium">{c.who}</span> ({c.count} คน)</p>
                      <button className="text-[13px] font-bold px-3 py-1.5 rounded-lg cursor-pointer flex items-center gap-1.5" style={{background:'linear-gradient(135deg,#FBBF24,#F59E0B)',color:'#1a1a1a'}}
                        onClick={e=>{e.stopPropagation(); window.open('https://www.iddrives.com','_blank');}}>
                        <Icon type="send" className="h-3 w-3" style={{color:'#1a1a1a'}}/> ลงทะเบียน iDDrives
                      </button>
                    </div>
                  </div>
                ))}
                <div className="rounded-xl p-3 mt-2 flex items-center gap-2" style={{background:'rgba(96,165,250,0.05)',border:'1px solid rgba(96,165,250,0.1)'}}>
                  <span className="text-[13px]">💡</span>
                  <p className="text-[13px] text-neutral-400">กด "หาหลักสูตร" หรือ "ลงทะเบียน" → เปิด iDDrives แจ้ง TSM/ผู้ขับ → อบรมเสร็จระบบอัพเดทวุฒิบัตรอัตโนมัติ</p>
                </div>
              </div>
            </div>
          </div>)}
          {rTab === 'fleet' && (<div className="rounded-2xl overflow-hidden" style={{boxShadow:'0 4px 20px rgba(0,0,0,0.3)',border:'1px solid rgba(255,255,255,0.06)'}}>
            <div className="px-4 py-2.5" style={{background:'linear-gradient(135deg,#FBBF24,#F59E0B)'}}><p style={{fontSize:14,fontWeight:800,color:'#1a1a1a',margin:0}}>เอกสาร/วันหมดอายุ</p></div>
            <div className="p-3">{[{n:'บบ-7765',d:'พ.ร.บ.',s:'หมดแล้ว!',cl:'#F87171'},{n:'80-4517',d:'ภาษีรถ',s:'อีก 12 วัน',cl:'#F87171'},{n:'วิชัย',d:'ใบขับขี่',s:'อีก 17 วัน',cl:'#F87171'},{n:'กน-1658',d:'ประกันภัย',s:'อีก 2 เดือน',cl:'#FBBF24'},{n:'ผก-2244',d:'ตรวจสภาพ',s:'อีก 3 เดือน',cl:'#34D399'}].map((e,i) => (
              <div key={i} className="flex items-center gap-3 px-2 py-2.5 rounded-xl cursor-pointer transition-all" onMouseEnter={ev=>{ev.currentTarget.style.background='rgba(255,255,255,0.02)';}} onMouseLeave={ev=>{ev.currentTarget.style.background='transparent';}}>
                <div className="w-7 h-7 rounded-lg flex items-center justify-center" style={{background:e.cl+'15'}}><Icon type="car" className="h-3 w-3" style={{color:e.cl}}/></div>
                <div className="flex-1"><p className="text-sm text-white">{e.n}</p><p className="text-[13px] text-neutral-500">{e.d}</p></div>
                <span className="text-[13px] font-bold px-2 py-0.5 rounded-lg" style={{background:e.cl+'15',color:e.cl}}>{e.s}</span>
              </div>))}</div>
          </div>)}
        </div>);
      })()}

      {/* ═══ Tracking (Owner) ═══ */}
      {pageKey === 'tracking' && (
        <div className="space-y-4">
          <GPSMap mode="all" />
          <div className="grid grid-cols-2 xl:grid-cols-4 gap-3">
            {[{l:'งานวันนี้',v:'18/22',cl:'#34D399',icon:'check'},{l:'ภารกิจ',v:'4',cl:'#FBBF24',icon:'clock'},{l:'เกินกำหนด',v:'1',cl:'#F87171',icon:'incident'},{l:'รถวิ่งอยู่',v:'5/8',cl:'#60A5FA',icon:'truck'}].map((m,i) => (
              <div key={i} className="rounded-2xl p-4" style={{border:'1px solid rgba(255,255,255,0.06)',background:'linear-gradient(135deg,rgba(255,255,255,0.03),transparent)'}}>
                <div className="flex items-center justify-between mb-2">
                  <p className="text-sm text-neutral-400">{m.l}</p>
                  <div className="w-7 h-7 rounded-lg flex items-center justify-center" style={{background:m.cl+'15'}}><Icon type={m.icon} className="h-3.5 w-3.5" style={{color:m.cl}}/></div>
                </div>
                <p className="text-3xl font-bold" style={{color:m.cl}}>{m.v}</p>
              </div>
            ))}
          </div>
          <div className="rounded-2xl overflow-hidden" style={{border:'1px solid rgba(255,255,255,0.06)'}}>
            <div style={{height:3,background:'linear-gradient(90deg,#60A5FA,transparent)'}}/>
            <div className="p-4">
              <p className="text-sm font-bold text-white mb-3">สถานะผู้ขับรถวันนี้</p>
              {[{n:'ประเสริฐ รถมั่นคง',v:'กน-1658',s:'วิ่งงาน',km:'142 km',cl:'#34D399',pct:82},{n:'สุรชัย ขับดี',v:'1กฐ-6852',s:'วิ่งงาน',km:'98 km',cl:'#34D399',pct:65},{n:'อนันต์ ปลอดภัย',v:'บท-3091',s:'พักเที่ยง',km:'67 km',cl:'#FBBF24',pct:45}].map((d,i) => (
                <div key={i} className="flex items-center gap-3 py-3 cursor-pointer transition-all duration-150" style={{borderBottom:i<2?'1px solid rgba(255,255,255,0.04)':'none'}}
                  onMouseEnter={e=>{e.currentTarget.style.background='rgba(255,255,255,0.02)';e.currentTarget.style.paddingLeft='4px';}}
                  onMouseLeave={e=>{e.currentTarget.style.background='';e.currentTarget.style.paddingLeft='';}}>
                  <div className="w-9 h-9 rounded-xl flex items-center justify-center text-white text-sm font-bold shrink-0" style={{background:'linear-gradient(135deg,#FBBF24,#F59E0B)'}}>{d.n[0]}</div>
                  <div className="flex-1 min-w-0">
                    <p className="text-sm text-white font-medium">{d.n}</p>
                    <div className="flex items-center gap-2 mt-1">
                      <span className="text-[13px] text-neutral-500">{d.v} • {d.km}</span>
                      <div className="flex-1 h-1 rounded-full bg-neutral-800 max-w-[80px]"><div className="h-full rounded-full" style={{width:`${d.pct}%`,background:d.cl}}/></div>
                    </div>
                  </div>
                  <span className="text-[13px] font-bold px-2 py-0.5 rounded-md shrink-0" style={{background:d.cl+'15',color:d.cl}}>{d.s}</span>
                </div>
              ))}
            </div>
          </div>
        </div>
      )}

      {/* ═══ Fleet+People (Owner) ═══ */}
      {pageKey === 'fleetPeople' && (
        <div className="space-y-4">
          {/* Stats */}
          <div className="grid grid-cols-2 xl:grid-cols-4 gap-3">
            {[{l:'รถทั้งหมด',v:'8',cl:'#60A5FA',icon:'car'},{l:'พร้อมใช้',v:'6',cl:'#34D399',icon:'check'},{l:'ซ่อมบำรุง',v:'1',cl:'#FBBF24',icon:'settings'},{l:'เอกสารใกล้หมด',v:'3',cl:'#F87171',icon:'incident'}].map((m,i) => (
              <div key={i} className="rounded-2xl p-4" style={{border:'1px solid rgba(255,255,255,0.06)',background:'linear-gradient(135deg,rgba(255,255,255,0.03),transparent)'}}>
                <div className="flex items-center justify-between mb-2">
                  <p className="text-sm text-neutral-400">{m.l}</p>
                  <div className="w-7 h-7 rounded-lg flex items-center justify-center" style={{background:m.cl+'15'}}><Icon type={m.icon} className="h-3.5 w-3.5" style={{color:m.cl}}/></div>
                </div>
                <p className="text-3xl font-bold" style={{color:m.cl}}>{m.v}</p>
              </div>
            ))}
          </div>

          {/* ═══ Expiry Alert Dashboard ═══ */}
          <div className="rounded-2xl overflow-hidden" style={{border:'1px solid rgba(248,113,113,0.2)'}}>
            <div style={{height:3,background:'linear-gradient(90deg,#F87171,#FBBF24,transparent)'}}/>
            <div className="p-4" style={{background:'linear-gradient(135deg,rgba(248,113,113,0.04),transparent)'}}>
              <div className="flex items-center gap-2 mb-3">
                <Icon type="incident" className="h-4 w-4 text-red-400"/>
                <p className="text-sm font-bold text-red-400">เอกสาร/วันหมดอายุ — ต้องดำเนินการ</p>
              </div>
              {[
                {type:'รถ',name:'บบ-7765 อุดรธานี',doc:'พ.ร.บ.',expire:'15 มี.ค. 2569',days:-14,cl:'#F87171',urgency:'หมดแล้ว!'},
                {type:'รถ',name:'80-4517 ชลบุรี',doc:'ภาษีรถประจำปี',expire:'10 เม.ย. 2569',days:12,cl:'#F87171',urgency:'อีก 12 วัน'},
                {type:'รถ',name:'กน-1658 กรุงเทพ',doc:'ประกันภัยชั้น 1',expire:'30 พ.ค. 2569',days:62,cl:'#FBBF24',urgency:'อีก 2 เดือน'},
                {type:'คน',name:'วิชัย ส่งด่วน',doc:'ใบขับขี่',expire:'15 เม.ย. 2569',days:17,cl:'#F87171',urgency:'อีก 17 วัน'},
                {type:'คน',name:'ธนา เดินทาง',doc:'ใบขับขี่',expire:'30 มิ.ย. 2569',days:93,cl:'#FBBF24',urgency:'อีก 3 เดือน'},
                {type:'รถ',name:'ผก-2244 ขอนแก่น',doc:'ตรวจสภาพรถ',expire:'1 ก.ค. 2569',days:94,cl:'#34D399',urgency:'อีก 3 เดือน'},
              ].map((e,i) => (
                <div key={i} className="flex items-center gap-3 py-3 cursor-pointer transition-all duration-150"
                  style={{borderBottom:i<5?'1px solid rgba(255,255,255,0.04)':'none'}}
                  onMouseEnter={ev=>{ev.currentTarget.style.background='rgba(255,255,255,0.02)';ev.currentTarget.style.paddingLeft='4px';}}
                  onMouseLeave={ev=>{ev.currentTarget.style.background='';ev.currentTarget.style.paddingLeft='';}}>
                  <div className="w-9 h-9 rounded-xl flex items-center justify-center shrink-0" style={{background:e.cl+'15'}}>
                    <Icon type={e.type==='รถ'?'car':'users'} className="h-4 w-4" style={{color:e.cl}}/>
                  </div>
                  <div className="flex-1 min-w-0">
                    <div className="flex items-center gap-2">
                      <p className="text-sm text-white font-medium">{e.name}</p>
                      <span className="text-[13px] px-1.5 py-0.5 rounded" style={{background:'rgba(255,255,255,0.04)',color:'rgba(255,255,255,0.4)'}}>{e.type}</span>
                    </div>
                    <p className="text-[13px] text-neutral-500">{e.doc} • หมดอายุ {e.expire}</p>
                  </div>
                  <div className="text-right shrink-0">
                    <span className="text-[13px] font-bold px-2 py-1 rounded-lg" style={{background:e.cl+'15',color:e.cl}}>{e.urgency}</span>
                  </div>
                </div>
              ))}
            </div>
          </div>

          {/* ═══ Upcoming Schedule ═══ */}
          <div className="rounded-2xl overflow-hidden" style={{border:'1px solid rgba(251,191,36,0.15)'}}>
            <div style={{height:3,background:'linear-gradient(90deg,#FBBF24,transparent)'}}/>
            <div className="p-4" style={{background:'linear-gradient(135deg,rgba(251,191,36,0.04),transparent)'}}>
              <div className="flex items-center gap-2 mb-3">
                <Icon type="clock" className="h-4 w-4 text-yellow-400"/>
                <p className="text-sm font-bold text-yellow-400">กำหนดการที่จะถึง (30 วัน)</p>
              </div>
              {[
                {name:'80-4517 ชลบุรี',task:'ต่อภาษีรถประจำปี',date:'10 เม.ย.',action:'นัดต่อภาษี'},
                {name:'วิชัย ส่งด่วน',task:'ต่ออายุใบขับขี่',date:'15 เม.ย.',action:'นัดทำใบขับขี่'},
                {name:'บท-3091 นครราชสีมา',task:'เปลี่ยนถ่ายน้ำมัน (50,000 km)',date:'20 เม.ย.',action:'จองคิวศูนย์'},
              ].map((t,i) => (
                <div key={i} className="flex items-center gap-3 py-2.5" style={{borderBottom:i<2?'1px solid rgba(255,255,255,0.04)':'none'}}>
                  <div className="w-8 h-8 rounded-lg flex items-center justify-center" style={{background:'rgba(251,191,36,0.1)'}}><Icon type="clock" className="h-3.5 w-3.5 text-yellow-400"/></div>
                  <div className="flex-1 min-w-0">
                    <p className="text-sm text-white">{t.name} — {t.task}</p>
                    <p className="text-[13px] text-neutral-500">{t.date}</p>
                  </div>
                  <button className="text-[13px] font-bold px-2.5 py-1 rounded-lg cursor-pointer" style={{background:'rgba(251,191,36,0.1)',color:'#FBBF24'}}>{t.action}</button>
                </div>
              ))}
            </div>
          </div>

          {/* ═══ Vehicle list ═══ */}
          <div className="rounded-2xl overflow-hidden" style={{border:'1px solid rgba(255,255,255,0.06)'}}>
            <div style={{height:2,background:'linear-gradient(90deg,#60A5FA,transparent)'}}/>
            <div className="p-4">
              <p className="text-sm font-bold text-white mb-3">รถทั้งหมด (8 คัน)</p>
              {[
                {r:'กน-1658 กรุงเทพ',t:'6 ล้อ • HINO 500',d:'ประเสริฐ',km:'45,230 km',prb:'31 ธ.ค. 69',prbCl:'#34D399',ins:'30 พ.ค. 69',insCl:'#FBBF24'},
                {r:'1กฐ-6852 ขอนแก่น',t:'10 ล้อ • ISUZU FTR',d:'สุรชัย',km:'38,100 km',prb:'30 มิ.ย. 70',prbCl:'#34D399',ins:'31 ธ.ค. 69',insCl:'#34D399'},
                {r:'80-4517 ชลบุรี',t:'18 ล้อ • VOLVO FH',d:'—',km:'120,500 km',prb:'10 เม.ย. 69',prbCl:'#F87171',ins:'ไม่มีข้อมูล',insCl:'#6B7280'},
                {r:'บบ-7765 อุดรธานี',t:'6 ล้อ • HINO 300',d:'—',km:'95,100 km',prb:'15 มี.ค. 69',prbCl:'#F87171',ins:'หมดแล้ว',insCl:'#F87171'},
              ].map((v,i) => (
                <div key={i} className="flex items-center gap-3 py-3 cursor-pointer transition-all duration-150"
                  style={{borderBottom:i<3?'1px solid rgba(255,255,255,0.04)':'none'}}
                  onMouseEnter={ev=>{ev.currentTarget.style.background='rgba(255,255,255,0.02)';}}
                  onMouseLeave={ev=>{ev.currentTarget.style.background='';}}>
                  <div className="w-9 h-9 rounded-xl flex items-center justify-center" style={{background:'rgba(96,165,250,0.1)'}}><Icon type="car" className="h-4 w-4 text-sky-400"/></div>
                  <div className="flex-1 min-w-0">
                    <p className="text-sm text-white font-medium">{v.r}</p>
                    <p className="text-[13px] text-neutral-500">{v.t} • ผู้ขับ: {v.d} • {v.km}</p>
                  </div>
                  <div className="text-right shrink-0">
                    <p className="text-[13px]"><span className="text-neutral-500">พ.ร.บ. </span><span style={{color:v.prbCl}} className="font-bold">{v.prb}</span></p>
                    <p className="text-[13px]"><span className="text-neutral-500">ประกัน </span><span style={{color:v.insCl}} className="font-bold">{v.ins}</span></p>
                  </div>
                </div>
              ))}
            </div>
          </div>
        </div>
      )}

      {/* ═══ My Work (Driver) ═══ */}
      {pageKey === 'myWork' && (
        <div className="space-y-3">
          {/* Today hero — route info + progress ring */}
          <div className="rounded-2xl overflow-hidden" style={{border:'1px solid rgba(251,191,36,0.15)'}}>
            <div style={{height:3,background:'linear-gradient(90deg,#FBBF24,#F59E0B,#34D399)'}}/>
            <div className="p-4" style={{background:'linear-gradient(135deg,rgba(251,191,36,0.06),transparent)'}}>
              <div className="flex items-center gap-3 mb-3">
                <div className="w-12 h-12 rounded-2xl flex items-center justify-center shrink-0" style={{background:'linear-gradient(135deg,#FBBF24,#F59E0B)'}}>
                  <Icon type="truck" className="h-6 w-6 text-neutral-900"/>
                </div>
                <div className="flex-1">
                  <p className="text-base font-bold text-yellow-400">งานวันนี้ 30 มี.ค. 2569</p>
                  <p className="text-[13px] text-neutral-400">กน-1658 กรุงเทพ • HINO 500 6ล้อ</p>
                </div>
                <div className="w-14 h-14 rounded-full flex items-center justify-center shrink-0" style={{background:'conic-gradient(#34D399 0deg, #34D399 154deg, #FBBF24 154deg, #FBBF24 180deg, rgba(255,255,255,0.06) 180deg)',borderRadius:'50%'}}>
                  <div className="w-10 h-10 rounded-full flex items-center justify-center" style={{background:'#0a1628'}}>
                    <span className="text-sm font-black text-yellow-400">3/7</span>
                  </div>
                </div>
              </div>
              <div className="flex gap-2">
                <div className="flex-1 rounded-xl p-2 text-center" style={{background:'rgba(255,255,255,0.03)'}}>
                  <p className="text-[13px] text-neutral-500">เส้นทาง</p>
                  <p className="text-[13px] text-white font-medium">ขอนแก่น → กรุงเทพฯ</p>
                </div>
                <div className="flex-1 rounded-xl p-2 text-center" style={{background:'rgba(255,255,255,0.03)'}}>
                  <p className="text-[13px] text-neutral-500">ระยะทาง</p>
                  <p className="text-[13px] text-sky-400 font-bold">450 km</p>
                </div>
                <div className="flex-1 rounded-xl p-2 text-center" style={{background:'rgba(255,255,255,0.03)'}}>
                  <p className="text-[13px] text-neutral-500">คะแนนวันนี้</p>
                  <p className="text-[13px] text-yellow-400 font-bold">+22/54</p>
                </div>
              </div>
            </div>
          </div>

          {/* Note from TSM */}
          <div className="rounded-xl p-3 flex items-start gap-2.5" style={{background:'rgba(167,139,250,0.05)',border:'1px solid rgba(167,139,250,0.12)'}}>
            <span className="text-sm mt-0.5">💬</span>
            <div>
              <p className="text-[13px] text-purple-400 font-bold">หมายเหตุจาก TSM สมชาย</p>
              <p className="text-[13px] text-neutral-400">ลูกค้ารอของด่วน, เส้นทางมีก่อสร้างช่วงสระบุรี</p>
            </div>
          </div>

          {/* Quick action — what to do NOW */}
          {(() => {
            const tasks = [
              {s:1,l:'ROLLCALL ก่อนปฏิบัติงาน',t:'07:30',st:'done',d:'แอลกอฮอล์ 0 mg% ✓',pts:10,form:'F02'},
              {s:2,l:'ตรวจความพร้อมรถ',t:'07:45',st:'done',d:'สภาพดี ครบ ✓',pts:12,form:'F01'},
              {s:3,l:'ตรวจเส้นทาง + สินค้า',t:'08:00',st:'done',d:'ขอนแก่น→กรุงเทพฯ 450km',pts:8,form:'F03'},
              {s:4,l:'GPS Tracking อัตโนมัติ',t:'ตลอดทาง',st:'active',d:'ปิดจอได้ — GPS บันทึกให้',pts:6,form:'F05'},
              {s:5,l:'ROLLCALL ระหว่างปฏิบัติงาน',t:'~12:00',st:'wait',d:'ระบบแจ้งเตือนเมื่อถึงเวลา',pts:8,form:'F06'},
              {s:6,l:'ROLLCALL หลังปฏิบัติงาน',t:'~17:00',st:'wait',d:'ตอบ 5 ข้อ กดเลือก',pts:8,form:'F08'},
              {s:7,l:'Log Book สรุปเที่ยว',t:'จบงาน',st:'wait',d:'ระบบสรุปจาก GPS อัตโนมัติ',pts:2,form:'F11'},
            ];
            const currentTask = tasks.find(t => t.st === 'active');
            return (
            <div>
              {/* Current task highlight */}
              {currentTask && (
                <div className="rounded-2xl overflow-hidden mb-3" style={{border:'2px solid rgba(251,191,36,0.2)'}}>
                  <div style={{height:3,background:'linear-gradient(90deg,#FBBF24,transparent)'}}/>
                  <div className="p-4 flex items-center gap-3" style={{background:'rgba(251,191,36,0.05)'}}>
                    <div className="w-11 h-11 rounded-xl flex items-center justify-center text-lg shrink-0" style={{background:'linear-gradient(135deg,#FBBF24,#F59E0B)',boxShadow:'0 0 16px rgba(251,191,36,0.2)'}}>
                      <Icon type="route" className="h-5 w-5 text-neutral-900"/>
                    </div>
                    <div className="flex-1">
                      <p className="text-[13px] text-yellow-400 font-bold uppercase tracking-wider">กำลังทำอยู่</p>
                      <p className="text-base font-bold text-white">{currentTask.l}</p>
                      <p className="text-[13px] text-neutral-400">{currentTask.d}</p>
                    </div>
                    <div className="text-right shrink-0">
                      <p className="text-[13px] font-bold text-yellow-400">+{currentTask.pts} pt</p>
                    </div>
                  </div>
                </div>
              )}

              {/* Timeline */}
              <div className="rounded-2xl overflow-hidden" style={{border:'1px solid rgba(255,255,255,0.06)'}}>
                <div className="px-4 py-2.5 flex items-center justify-between" style={{borderBottom:'1px solid rgba(255,255,255,0.04)'}}>
                  <p className="text-sm font-bold text-white">ลำดับงาน</p>
                  <p className="text-[13px] text-neutral-500">{tasks.filter(t=>t.st==='done').length} เสร็จ • {tasks.filter(t=>t.st==='wait').length} รอ</p>
                </div>
                <div className="p-2">
                  {tasks.map((s,i) => (
                    <div key={i} className="flex items-center gap-3 px-2 py-2.5 rounded-xl transition-all duration-150 cursor-pointer"
                      style={{background:s.st==='active'?'rgba(251,191,36,0.04)':'transparent',opacity:s.st==='wait'?0.5:1}}
                      onMouseEnter={e=>{if(s.st!=='done')e.currentTarget.style.background='rgba(251,191,36,0.04)';e.currentTarget.style.paddingLeft='12px';}}
                      onMouseLeave={e=>{e.currentTarget.style.background=s.st==='active'?'rgba(251,191,36,0.04)':'transparent';e.currentTarget.style.paddingLeft='8px';}}>
                      {/* Status dot */}
                      <div className="w-7 h-7 rounded-lg flex items-center justify-center text-[13px] font-bold shrink-0" style={{
                        background:s.st==='done'?'rgba(52,211,153,0.15)':s.st==='active'?'linear-gradient(135deg,#FBBF24,#F59E0B)':'rgba(255,255,255,0.04)',
                        color:s.st==='done'?'#34D399':s.st==='active'?'#1a1a1a':'rgba(255,255,255,0.3)',
                      }}>
                        {s.st==='done'?'✓':s.s}
                      </div>
                      {/* Info */}
                      <div className="flex-1 min-w-0">
                        <p className="text-sm font-medium" style={{color:s.st==='done'?'#34D399':s.st==='active'?'#FBBF24':'rgba(255,255,255,0.4)'}}>{s.l}</p>
                        <p className="text-[13px] text-neutral-500">{s.d}</p>
                      </div>
                      {/* Right: time + points */}
                      <div className="text-right shrink-0">
                        <p className="text-[13px]" style={{color:s.st==='done'?'#34D399':s.st==='active'?'#FBBF24':'rgba(255,255,255,0.25)'}}>{s.t}</p>
                        <p className="text-[13px]" style={{color:s.st==='done'?'rgba(52,211,153,0.5)':'rgba(255,255,255,0.2)'}}>+{s.pts} pt</p>
                      </div>
                    </div>
                  ))}
                </div>
              </div>
            </div>
            );
          })()}
        </div>
      )}

      {/* ═══ My Vehicle (Driver) ═══ */}
      {pageKey === 'myVehicle' && (
        <div className="space-y-4">
          {/* Vehicle hero card */}
          <div className="rounded-2xl overflow-hidden" style={{border:'1px solid rgba(96,165,250,0.15)'}}>
            <div style={{height:3,background:'linear-gradient(90deg,#60A5FA,#38BDF8,transparent)'}}/>
            <div className="p-5" style={{background:'linear-gradient(135deg,rgba(96,165,250,0.06),transparent)'}}>
              <div className="flex items-center gap-4">
                <div className="w-14 h-14 rounded-2xl flex items-center justify-center shrink-0" style={{background:'linear-gradient(135deg,#60A5FA,#38BDF8)'}}><Icon type="car" className="h-6 w-6 text-white" /></div>
                <div className="flex-1">
                  <p className="text-xl font-bold text-white">กน-1658</p>
                  <p className="text-sm text-neutral-400">รถบรรทุก 6 ล้อ • HINO 500</p>
                </div>
                <span className="text-[13px] font-bold px-3 py-1 rounded-lg" style={{background:'rgba(52,211,153,0.15)',color:'#34D399'}}>พร้อมใช้</span>
              </div>
              {/* Mini stats */}
              <div className="flex gap-3 mt-4">
                {[{l:'ระยะทาง',v:'45,230 km',cl:'#60A5FA'},{l:'น้ำหนักสูงสุด',v:'8,000 kg',cl:'#FBBF24'},{l:'พ.ร.บ.',v:'31 ธ.ค. 69',cl:'#34D399'}].map((s,i)=>(
                  <div key={i} className="flex-1 rounded-xl p-2.5 text-center" style={{background:'rgba(255,255,255,0.03)',border:'1px solid rgba(255,255,255,0.05)'}}>
                    <p className="text-[13px] text-neutral-500">{s.l}</p>
                    <p className="text-[13px] font-bold mt-0.5" style={{color:s.cl}}>{s.v}</p>
                  </div>
                ))}
              </div>
            </div>
          </div>
          <GPSMap mode="single" />

          {/* Details */}
          <div className="rounded-2xl p-4" style={{border:'1px solid rgba(255,255,255,0.06)'}}>
            <p className="text-sm font-bold text-white mb-3">รายละเอียดรถ</p>
            {[{l:'ทะเบียน',v:'กน-1658 ขอนแก่น',icon:'car'},{l:'ระยะทางสะสม',v:'45,230 km',icon:'route'},{l:'บำรุงรักษาถัดไป',v:'15 เม.ย. 2569',icon:'clock'},{l:'ประกันหมดอายุ',v:'31 ธ.ค. 2569',icon:'shield'}].map((f,i) => (
              <div key={i} className="flex items-center gap-3 py-2.5" style={{borderBottom:i<3?'1px solid rgba(255,255,255,0.04)':'none'}}>
                <Icon type={f.icon} className="h-3.5 w-3.5 text-neutral-600 shrink-0"/>
                <span className="text-sm text-neutral-400 flex-1">{f.l}</span>
                <span className="text-sm text-white font-medium">{f.v}</span>
              </div>
            ))}
          </div>
          {/* Report button */}
          <button className="w-full h-12 rounded-2xl text-sm font-bold cursor-pointer flex items-center justify-center gap-2 transition-all duration-200" style={{background:'rgba(248,113,113,0.08)',border:'1px solid rgba(248,113,113,0.15)',color:'#F87171'}}
            onMouseEnter={e=>{e.currentTarget.style.transform='translateY(-1px)';}} onMouseLeave={e=>{e.currentTarget.style.transform='';}}>
            <Icon type="incident" className="h-4 w-4"/> แจ้งปัญหารถ
          </button>
        </div>
      )}

      {/* ═══ My History (Driver) ═══ */}
      {/* ═══ Safety Analysis 5 Dimensions ═══ */}
      {pageKey === 'safetyAnalysis' && (() => {
        const dims = [
          {id:1,title:'การจัดการรถ',short:'รถ',score:92,prev:87,target:90,cl:'#60A5FA',forms:'F01, F10, F12',kpis:[{k:'ตรวจรถก่อนออก',v:'22/24',pct:92},{k:'บำรุงรักษาตามแผน',v:'83%',pct:83},{k:'พ.ร.บ./ประกัน ครบ',v:'75%',pct:75}]},
          {id:2,title:'การจัดการผู้ขับ',short:'ผู้ขับ',score:88,prev:82,target:85,cl:'#34D399',forms:'F02, F06, F08, F13, F14',kpis:[{k:'ROLLCALL ครบ',v:'83%',pct:83},{k:'แอลกอฮอล์ 0 mg%',v:'100%',pct:100},{k:'ผ่านอบรม',v:'78%',pct:78}]},
          {id:3,title:'การจัดการเดินรถ',short:'เดินรถ',score:95,prev:90,target:85,cl:'#FBBF24',forms:'F03, F05, F11',kpis:[{k:'ตรวจเส้นทาง',v:'100%',pct:100},{k:'ความเร็ว ≤ 90 km/h',v:'98%',pct:98},{k:'หยุดพัก ≤ 4 ชม.',v:'92%',pct:92}]},
          {id:4,title:'การบรรทุก/โดยสาร',short:'บรรทุก',score:91,prev:88,target:85,cl:'#A78BFA',forms:'F04',kpis:[{k:'น้ำหนัก ≤ กำหนด',v:'95%',pct:95},{k:'ตรวจสินค้าครบ',v:'90%',pct:90},{k:'ปฏิบัติตามคู่มือ',v:'88%',pct:88}]},
          {id:5,title:'วิเคราะห์/ประเมิน',short:'วิเคราะห์',score:85,prev:72,target:80,cl:'#F87171',forms:'F09, F15, F16, F17',kpis:[{k:'ส่งรายงานกรมฯ',v:'2/4',pct:50},{k:'แก้ไขปัญหาครบ',v:'80%',pct:80},{k:'อุบัติเหตุ',v:'0 ครั้ง',pct:100}]},
        ];
        const avg = Math.round(dims.reduce((s,d)=>s+d.score,0)/dims.length);
        const prevAvg = Math.round(dims.reduce((s,d)=>s+d.prev,0)/dims.length);
        return (
          <div className="space-y-3">
            {/* ═══ Score overview — big number + radar ═══ */}
            <div className="rounded-2xl overflow-hidden" style={{boxShadow:'0 4px 20px rgba(0,0,0,0.3)',border:'1px solid rgba(251,191,36,0.15)'}}>
              <div className="px-4 py-2.5" style={{background:'linear-gradient(135deg,#FBBF24,#F59E0B)'}}>
                <p style={{fontSize:14,fontWeight:800,color:'#1a1a1a',margin:0}}>คะแนนความปลอดภัยรวม — Q1/2569</p>
              </div>
              <div className="p-4">
                <div className="flex gap-4">
                  {/* Left: Big score + gauge */}
                  <div className="flex-1 text-center">
                    <div className="relative w-32 h-32 mx-auto mb-3">
                      <svg viewBox="0 0 100 100" className="w-full h-full" style={{transform:'rotate(-90deg)'}}>
                        <circle cx="50" cy="50" r="42" fill="none" stroke="rgba(255,255,255,0.06)" strokeWidth="8"/>
                        <circle cx="50" cy="50" r="42" fill="none" stroke={avg>=90?'#34D399':avg>=80?'#FBBF24':'#F87171'} strokeWidth="8" strokeLinecap="round"
                          strokeDasharray={`${avg*2.64} ${264-avg*2.64}`}>
                          <animate attributeName="stroke-dasharray" from="0 264" to={`${avg*2.64} ${264-avg*2.64}`} dur="1.5s" fill="freeze"/>
                        </circle>
                      </svg>
                      <div className="absolute inset-0 flex flex-col items-center justify-center">
                        <span className="text-3xl font-black" style={{color:avg>=90?'#34D399':avg>=80?'#FBBF24':'#F87171'}}>{avg}</span>
                        <span className="text-[13px] text-neutral-500">/100</span>
                      </div>
                    </div>
                    <p className="text-sm text-white font-bold">{avg >= 90 ? 'ยอดเยี่ยม!' : avg >= 80 ? 'ดี' : 'ต้องปรับปรุง'}</p>
                    <p className="text-[13px] text-neutral-500">เกณฑ์กรมฯ: 70 คะแนน</p>
                    <div className="flex items-center justify-center gap-2 mt-2">
                      <span className="text-[13px] font-bold" style={{color:'#34D399'}}>+{avg - prevAvg}</span>
                      <span className="text-[13px] text-neutral-500">จากไตรมาสก่อน ({prevAvg})</span>
                    </div>
                  </div>
                  {/* Right: Radar-like pentagon */}
                  <div className="flex-1">
                    <svg viewBox="0 0 200 200" className="w-full max-w-[200px] mx-auto">
                      {/* Pentagon grid */}
                      {[20,40,60,80,100].map(r => {
                        const pts = [0,1,2,3,4].map(i => {
                          const a = (i * 72 - 90) * Math.PI / 180;
                          return `${100+r*0.8*Math.cos(a)},${100+r*0.8*Math.sin(a)}`;
                        }).join(' ');
                        return <polygon key={r} points={pts} fill="none" stroke="rgba(255,255,255,0.06)" strokeWidth="0.5"/>;
                      })}
                      {/* Data polygon */}
                      {(() => {
                        const pts = dims.map((d,i) => {
                          const a = (i * 72 - 90) * Math.PI / 180;
                          const r = d.score * 0.8;
                          return `${100+r*Math.cos(a)},${100+r*Math.sin(a)}`;
                        }).join(' ');
                        return <polygon points={pts} fill="rgba(251,191,36,0.15)" stroke="#FBBF24" strokeWidth="2"/>;
                      })()}
                      {/* Data dots + labels */}
                      {dims.map((d,i) => {
                        const a = (i * 72 - 90) * Math.PI / 180;
                        const r = d.score * 0.8;
                        const lx = 100 + 92 * Math.cos(a);
                        const ly = 100 + 92 * Math.sin(a);
                        return (
                          <g key={i}>
                            <circle cx={100+r*Math.cos(a)} cy={100+r*Math.sin(a)} r="4" fill={d.cl} stroke="white" strokeWidth="1.5"/>
                            <text x={lx} y={ly+1} textAnchor="middle" fill={d.cl} fontSize="10" fontWeight="bold">{d.short}</text>
                            <text x={lx} y={ly+12} textAnchor="middle" fill="rgba(255,255,255,0.4)" fontSize="9">{d.score}</text>
                          </g>
                        );
                      })}
                    </svg>
                  </div>
                </div>
              </div>
            </div>

            {/* ═══ 5 Dimension cards — clickable ═══ */}
            <div className="grid grid-cols-5 gap-2">
              {dims.map(d => (
                <button key={d.id} onClick={() => setSelDim(selDim===d.id?null:d.id)}
                  className="rounded-2xl p-3 text-center cursor-pointer transition-all duration-200"
                  style={{border:selDim===d.id?'2px solid '+d.cl:'1px solid rgba(255,255,255,0.06)',background:selDim===d.id?d.cl+'10':'rgba(255,255,255,0.02)',boxShadow:'0 4px 16px rgba(0,0,0,0.2)',transform:selDim===d.id?'translateY(-4px)':''}}
                  onMouseEnter={e=>{if(selDim!==d.id)e.currentTarget.style.transform='translateY(-2px)';}}
                  onMouseLeave={e=>{if(selDim!==d.id)e.currentTarget.style.transform='';}}>
                  <div className="w-10 h-10 rounded-xl flex items-center justify-center mx-auto mb-2" style={{background:d.cl+'20'}}>
                    <span className="text-lg font-black" style={{color:d.cl}}>{d.id}</span>
                  </div>
                  <p className="text-2xl font-black" style={{color:d.cl}}>{d.score}</p>
                  <p className="text-[13px] text-neutral-500 mt-0.5">{d.short}</p>
                  <div className="flex items-center justify-center gap-1 mt-1">
                    <span className="text-[13px] font-bold" style={{color:d.score>d.prev?'#34D399':'#F87171'}}>{d.score>d.prev?'+':''}{d.score-d.prev}</span>
                  </div>
                </button>
              ))}
            </div>

            {/* ═══ Selected dimension detail ═══ */}
            {selDim && (() => {
              const d = dims.find(x=>x.id===selDim);
              return (
              <div className="rounded-2xl overflow-hidden" style={{border:'2px solid '+d.cl+'30',boxShadow:'0 4px 20px rgba(0,0,0,0.3)'}}>
                <div className="px-4 py-2.5 flex items-center gap-2" style={{background:'linear-gradient(135deg,#FBBF24,#F59E0B)'}}>
                  <div className="w-7 h-7 rounded-lg flex items-center justify-center" style={{background:'rgba(0,0,0,0.1)'}}><span style={{color:'#1a1a1a',fontWeight:800,fontSize:14}}>{d.id}</span></div>
                  <p style={{fontSize:14,fontWeight:800,color:'#1a1a1a',margin:0}}>ด้าน {d.id}: {d.title}</p>
                  <span style={{fontSize:13,color:'rgba(0,0,0,0.4)',marginLeft:'auto'}}>ฟอร์ม: {d.forms}</span>
                </div>
                <div className="p-4">
                  {/* Score comparison */}
                  <div className="flex gap-3 mb-4">
                    <div className="flex-1 rounded-xl p-3 text-center" style={{background:d.cl+'08',border:'1px solid '+d.cl+'20'}}>
                      <p className="text-2xl font-black" style={{color:d.cl}}>{d.score}</p>
                      <p className="text-[13px] text-neutral-500">ปัจจุบัน</p>
                    </div>
                    <div className="flex-1 rounded-xl p-3 text-center" style={{background:'rgba(255,255,255,0.02)',border:'1px solid rgba(255,255,255,0.06)'}}>
                      <p className="text-2xl font-bold text-neutral-500">{d.prev}</p>
                      <p className="text-[13px] text-neutral-600">ไตรมาสก่อน</p>
                    </div>
                    <div className="flex-1 rounded-xl p-3 text-center" style={{background:'rgba(255,255,255,0.02)',border:'1px solid rgba(255,255,255,0.06)'}}>
                      <p className="text-2xl font-bold text-neutral-500">{d.target}</p>
                      <p className="text-[13px] text-neutral-600">เป้าหมาย</p>
                    </div>
                  </div>
                  {/* KPI bars */}
                  {d.kpis.map((kpi,i) => (
                    <div key={i} className="mb-3">
                      <div className="flex items-center justify-between mb-1">
                        <p className="text-sm text-white">{kpi.k}</p>
                        <p className="text-sm font-bold" style={{color:kpi.pct>=90?'#34D399':kpi.pct>=70?'#FBBF24':'#F87171'}}>{kpi.v}</p>
                      </div>
                      <div className="h-3 rounded-full bg-neutral-800 overflow-hidden">
                        <div className="h-full rounded-full transition-all duration-700" style={{width:kpi.pct+'%',background:kpi.pct>=90?'linear-gradient(90deg,#34D399,#10B981)':kpi.pct>=70?'linear-gradient(90deg,#FBBF24,#F59E0B)':'linear-gradient(90deg,#F87171,#EF4444)'}}/>
                      </div>
                    </div>
                  ))}
                  {/* AI insight */}
                  <div className="rounded-xl p-3 flex items-start gap-2 mt-3" style={{background:d.score>=d.target?'rgba(52,211,153,0.05)':'rgba(248,113,113,0.05)',border:'1px solid '+(d.score>=d.target?'rgba(52,211,153,0.1)':'rgba(248,113,113,0.1)')}}>
                    <span className="text-base mt-0.5">{d.score>=d.target?'✅':'⚠️'}</span>
                    <p className="text-[13px]" style={{color:d.score>=d.target?'#34D399':'#F87171'}}>
                      {d.score>=d.target
                        ? `ผ่านเป้าหมาย ${d.target} คะแนน — ดีขึ้น +${d.score-d.prev} จากไตรมาสก่อน`
                        : `ยังไม่ถึงเป้า ${d.target} — ต้องเพิ่มอีก ${d.target-d.score} คะแนน`}
                    </p>
                  </div>
                </div>
              </div>
              );
            })()}

            {/* ═══ Advanced Analytics ═══ */}
              {/* Driving Behavior Score — วัดจาก data จริง */}
              <div className="rounded-2xl overflow-hidden" style={{boxShadow:'0 4px 20px rgba(0,0,0,0.3)',border:'1px solid rgba(255,255,255,0.06)'}}>
                <div className="px-4 py-2.5" style={{background:'linear-gradient(135deg,#FBBF24,#F59E0B)'}}>
                  <p style={{fontSize:14,fontWeight:800,color:'#1a1a1a',margin:0}}>คะแนนพฤติกรรมผู้ขับ</p>
                </div>
                <div className="p-3">
                  {[
                    {n:'ประเสริฐ',rollcall:100,inspect:100,forms:98,total:99,cl:'#34D399'},
                    {n:'สุรชัย',rollcall:95,inspect:95,forms:92,total:94,cl:'#34D399'},
                    {n:'อนันต์',rollcall:90,inspect:90,forms:85,total:88,cl:'#34D399'},
                    {n:'สมศักดิ์',rollcall:85,inspect:75,forms:78,total:79,cl:'#FBBF24'},
                    {n:'วิชัย',rollcall:70,inspect:63,forms:60,total:64,cl:'#F87171'},
                  ].map((d,i) => (
                    <div key={i} className="flex items-center gap-3 py-2.5" style={{borderBottom:i<4?'1px solid rgba(255,255,255,0.03)':'none'}}>
                      <div className="w-8 h-8 rounded-xl flex items-center justify-center text-[13px] font-bold text-white shrink-0" style={{background:'linear-gradient(135deg,#FBBF24,#F59E0B)'}}>{d.n[0]}</div>
                      <div className="flex-1 min-w-0">
                        <p className="text-sm text-white font-medium">{d.n}</p>
                        <div className="flex gap-1.5 mt-1.5">
                          {[{l:'ROLLCALL',v:d.rollcall},{l:'ตรวจรถ',v:d.inspect},{l:'ฟอร์มครบ',v:d.forms}].map((s,j) => (
                            <div key={j} className="flex-1">
                              <div className="flex items-center justify-between mb-0.5"><span className="text-[13px] text-neutral-600">{s.l}</span><span className="text-[13px] font-bold" style={{color:s.v>=90?'#34D399':s.v>=70?'#FBBF24':'#F87171'}}>{s.v}%</span></div>
                              <div className="h-1.5 rounded-full bg-neutral-800 overflow-hidden">
                                <div className="h-full rounded-full" style={{width:s.v+'%',background:s.v>=90?'#34D399':s.v>=70?'#FBBF24':'#F87171'}}/>
                              </div>
                            </div>
                          ))}
                        </div>
                      </div>
                      <div className="text-center shrink-0 ml-2">
                        <p className="text-xl font-black" style={{color:d.cl}}>{d.total}</p>
                        <p className="text-[13px] text-neutral-600">คะแนน</p>
                      </div>
                    </div>
                  ))}
                  <div className="rounded-xl p-3 mt-2 flex items-center gap-2" style={{background:'rgba(96,165,250,0.05)',border:'1px solid rgba(96,165,250,0.1)'}}>
                    <span className="text-[13px]">📊</span>
                    <p className="text-[13px] text-neutral-400">คะแนน = (ROLLCALL ครบ + ตรวจรถก่อนออก + ฟอร์มครบ) ÷ 3 — ข้อมูลจาก F01, F02, F06, F08</p>
                  </div>
                </div>
              </div>

            {/* ═══ Row 2: Predictive + On-Time + Route ═══ */}
            <div className="grid grid-cols-1 xl:grid-cols-2 gap-3">
              {/* Predictive Maintenance */}
              <div className="rounded-2xl overflow-hidden" style={{boxShadow:'0 4px 16px rgba(0,0,0,0.2)',border:'1px solid rgba(255,255,255,0.06)'}}>
                <div className="px-4 py-2.5" style={{background:'linear-gradient(135deg,#FBBF24,#F59E0B)'}}>
                  <p style={{fontSize:13,fontWeight:800,color:'#1a1a1a',margin:0}}>Predictive Maintenance</p>
                </div>
                <div className="p-3">
                  {[
                    {v:'1กฐ-6852',item:'เปลี่ยนน้ำมันเครื่อง',km:'อีก 2,100 km',cl:'#F87171'},
                    {v:'กน-1658',item:'เปลี่ยนผ้าเบรก',km:'อีก 5,400 km',cl:'#FBBF24'},
                    {v:'บท-3091',item:'เช็คระบบเกียร์',km:'อีก 8,000 km',cl:'#34D399'},
                  ].map((p,i) => (
                    <div key={i} className="flex items-center gap-2 py-2" style={{borderBottom:i<2?'1px solid rgba(255,255,255,0.03)':'none'}}>
                      <div className="w-2 h-2 rounded-full shrink-0" style={{background:p.cl}}/>
                      <div className="flex-1"><p className="text-[13px] text-white">{p.v}</p><p className="text-[13px] text-neutral-500">{p.item}</p></div>
                      <span className="text-[13px] font-bold" style={{color:p.cl}}>{p.km}</span>
                    </div>
                  ))}
                </div>
              </div>

              {/* On-Time Delivery */}
              <div className="rounded-2xl overflow-hidden" style={{boxShadow:'0 4px 16px rgba(0,0,0,0.2)',border:'1px solid rgba(255,255,255,0.06)'}}>
                <div className="px-4 py-2.5" style={{background:'linear-gradient(135deg,#FBBF24,#F59E0B)'}}>
                  <p style={{fontSize:13,fontWeight:800,color:'#1a1a1a',margin:0}}>On-Time Delivery</p>
                </div>
                <div className="p-3">
                  <div className="text-center mb-3">
                    <p className="text-3xl font-black text-emerald-400">92%</p>
                    <p className="text-[13px] text-neutral-500">ส่งตรงเวลา (57/62 เที่ยว)</p>
                  </div>
                  <div className="flex gap-2">
                    {[{l:'เร็วกว่า',v:'15',cl:'#34D399'},{l:'ตรงเวลา',v:'42',cl:'#60A5FA'},{l:'ช้า',v:'5',cl:'#F87171'}].map((s,i) => (
                      <div key={i} className="flex-1 rounded-xl p-2 text-center" style={{background:s.cl+'10'}}>
                        <p className="text-sm font-bold" style={{color:s.cl}}>{s.v}</p>
                        <p className="text-[13px] text-neutral-600">{s.l}</p>
                      </div>
                    ))}
                  </div>
                </div>
              </div>


            </div>

            {/* ═══ Trend 6 months ═══ */}
            <div className="rounded-2xl overflow-hidden" style={{boxShadow:'0 4px 20px rgba(0,0,0,0.3)',border:'1px solid rgba(255,255,255,0.06)'}}>
              <div className="px-4 py-2.5" style={{background:'linear-gradient(135deg,#FBBF24,#F59E0B)'}}>
                <p style={{fontSize:14,fontWeight:800,color:'#1a1a1a',margin:0}}>Trend Analysis — แนวโน้ม 6 เดือน</p>
              </div>
              <div className="p-4">
                <div className="flex items-end gap-1 h-28 mb-3">
                  {[{m:'ต.ค.',s:[78,72,80,82,60]},{m:'พ.ย.',s:[82,75,83,85,65]},{m:'ธ.ค.',s:[80,78,85,84,68]},{m:'ม.ค.',s:[85,82,88,87,72]},{m:'ก.พ.',s:[88,85,92,89,78]},{m:'มี.ค.',s:[92,88,95,91,85]}].map((month,mi) => {
                    const avg = Math.round(month.s.reduce((a,b)=>a+b,0)/5);
                    return (
                      <div key={mi} className="flex-1 flex flex-col items-center gap-0.5">
                        <span className="text-[13px] font-bold" style={{color:mi===5?'#FBBF24':'rgba(255,255,255,0.3)'}}>{avg}</span>
                        <div className="w-full rounded-t-md" style={{height:(avg/100*100)+'%',background:mi===5?'linear-gradient(180deg,#FBBF24,#F59E0B)':'rgba(255,255,255,0.06)'}}>
                          {mi===5 && month.s.map((s,si) => (
                            <div key={si} className="w-full" style={{height:'20%',background:dims[si].cl+'40',borderBottom:'1px solid rgba(0,0,0,0.1)'}}/>
                          ))}
                        </div>
                        <span className="text-[13px] text-neutral-600">{month.m}</span>
                      </div>
                    );
                  })}
                </div>
                <div className="flex flex-wrap gap-3 text-[13px]">
                  {dims.map((d,i) => (
                    <span key={i} className="flex items-center gap-1"><div className="w-3 h-2 rounded-sm" style={{background:d.cl}}/><span style={{color:d.cl}}>{d.short} {d.score}</span></span>
                  ))}
                  <span className="text-neutral-600 ml-auto">เกณฑ์กรมฯ: 70</span>
                </div>
                <div className="rounded-xl p-3 mt-3 flex items-center gap-2" style={{background:'rgba(52,211,153,0.05)',border:'1px solid rgba(52,211,153,0.1)'}}>
                  <span className="text-base">📈</span>
                  <p className="text-[13px] text-neutral-400">คะแนนเพิ่มขึ้นต่อเนื่อง 6 เดือน <span className="text-emerald-400 font-bold">+16 คะแนน</span> (74→90) — ทุกด้านสูงกว่าเกณฑ์กรมฯ (70)</p>
                </div>
              </div>
            </div>

            {/* ═══ AI Summary — Enhanced ═══ */}
            <div className="rounded-2xl overflow-hidden" style={{boxShadow:'0 4px 20px rgba(0,0,0,0.3)',border:'1px solid rgba(52,211,153,0.15)'}}>
              <div className="px-4 py-2.5" style={{background:'linear-gradient(135deg,#FBBF24,#F59E0B)'}}>
                <p style={{fontSize:14,fontWeight:800,color:'#1a1a1a',margin:0}}>AI วิเคราะห์ + คำแนะนำ</p>
              </div>
              <div className="p-3">
                {[
                  {icon:'📈',text:'ด้านเดินรถ (95) ดีที่สุด — GPS auto-fill ทำให้ compliance 100% ไม่ต้องกรอกเอง',cl:'#34D399',cat:'จุดแข็ง'},
                  {icon:'⚠️',text:'สมศักดิ์ Fatigue Risk 72% สูงสุดในทีม — ขับ 8.2 ชม./วัน + วันหยุดน้อย ควรลดเที่ยว',cl:'#F87171',cat:'เสี่ยง'},
                  {icon:'🔧',text:'1กฐ-6852 อีก 2,100 km ถึงรอบเปลี่ยนน้ำมันเครื่อง — นัดเข้าศูนย์ภายในสัปดาห์นี้',cl:'#F87171',cat:'บำรุงรักษา'},
                  {icon:'🏆',text:'อุบัติเหตุ 0 ครั้ง ต่อเนื่อง 3 เดือน — ROI 4.2 เท่า ทุก 1 บาทประหยัดได้ 4.2 บาท',cl:'#FBBF24',cat:'ผลลัพธ์'},
                  {icon:'💡',text:'อบรมวิชัย (Driving Score 64) จะเพิ่มด้านผู้ขับจาก 88→92 + ลดความเสี่ยง',cl:'#60A5FA',cat:'แนะนำ'},
                  {icon:'🚚',text:'On-Time 92% — เที่ยวที่ช้า 5 เที่ยวเกิดจากเส้นทางสระบุรี (ก่อสร้าง) เปลี่ยนเส้นทาง +8%',cl:'#A78BFA',cat:'ปรับปรุง'},
                ].map((tip,i) => (
                  <div key={i} className="flex items-start gap-3 px-2 py-2.5 rounded-xl" style={{borderBottom:i<5?'1px solid rgba(255,255,255,0.03)':'none'}}>
                    <span className="text-base mt-0.5 shrink-0">{tip.icon}</span>
                    <div className="flex-1"><span className="text-[13px] font-bold px-1.5 py-0.5 rounded mr-1.5" style={{background:tip.cl+'15',color:tip.cl}}>{tip.cat}</span><span className="text-[13px] text-neutral-300">{tip.text}</span></div>
                  </div>
                ))}
              </div>
            </div>
          </div>
        );
      })()}

            {pageKey === 'myHistory' && (
        <div className="space-y-4">
          <div className="grid grid-cols-2 xl:grid-cols-4 gap-3">
            {[{l:'ฟอร์มทำแล้ว',v:'48',cl:'text-emerald-400'},{l:'คะแนน',v:'680',cl:'text-yellow-400'},{l:'ชม.ขับรถ',v:'186:30',cl:'text-sky-400'},{l:'ระยะทาง',v:'4,280 km',cl:'text-purple-400'}].map((m,i) => (
              <div key={i} className="rounded-xl border border-white/5 bg-white/[0.02] p-4"><p className="text-[13px] text-neutral-500">{m.l}</p><p className={cn('text-2xl font-bold',m.cl)}>{m.v}</p></div>
            ))}
          </div>
          <div className="rounded-xl border border-white/5 bg-white/[0.02] p-4">
            <p className="text-sm font-bold text-white mb-3">ประวัติล่าสุด</p>
            {[{d:'29 มี.ค.',l:'ROLLCALL ก่อนปฏิบัติงาน',r:'ผ่าน',cl:'text-emerald-400'},{d:'29 มี.ค.',l:'ตรวจรถ กน-1658',r:'ปกติ',cl:'text-emerald-400'},{d:'28 มี.ค.',l:'Check-in นครราชสีมา',r:'142 km',cl:'text-sky-400'},{d:'28 มี.ค.',l:'ROLLCALL หลังปฏิบัติงาน',r:'0 mg%',cl:'text-emerald-400'}].map((h,i) => (
              <div key={i} className="flex items-center gap-3 py-2 border-b border-white/5 last:border-0">
                <span className="text-[13px] text-neutral-600 w-14 shrink-0">{h.d}</span>
                <p className="text-[13px] text-white flex-1">{h.l}</p>
                <span className={cn('text-[13px] font-bold',h.cl)}>{h.r}</span>
              </div>
            ))}
          </div>
        </div>
      )}

      {/* Info sections */}

    </div>
  );
}


/* ═══════════════════════════════════════════
   MAIN APP
   ═══════════════════════════════════════════ */
export default function TSMCPrototype() {
  const [role, setRole] = useState('tsm');
  const [pageKey, setPageKey] = useState('dashboard');
  React.useEffect(() => { window._setPageKey = setPageKey; return () => { delete window._setPageKey; }; }, []);
  const [showLogin, setShowLogin] = useState(true);
  const [showProfile, setShowProfile] = useState(false);
  const [setupStep, setSetupStep] = useState(0);
  const [showNotif, setShowNotif] = useState(false);
  const [dismissedNotifs, setDismissedNotifs] = useState([]);
  const [sessionMin, setSessionMin] = useState(30);
  const [sidebarOpen, setSidebarOpen] = useState(true);
  const [showProfilePage, setShowProfilePage] = useState(false);
  const [recentActions, setRecentActions] = useState([
    { type:'form', label:'ROLLCALL ก่อนปฏิบัติงาน', time:'07:30', nav:'documentsForms' },
    { type:'form', label:'ตรวจความพร้อมรถ กน-1658', time:'07:45', nav:'documentsForms' },
    { type:'assign', label:'จ่ายงาน → ประเสริฐ 3 ฟอร์ม', time:'08:00', nav:'assignWork' },
    { type:'import', label:'นำเข้ารถ 8 คัน + ผู้ใช้ 18 คน', time:'เมื่อวาน', nav:'orgData' },
    { type:'view', label:'รายงานไตรมาส 1 (พร้อมส่ง)', time:'เมื่อวาน', nav:'reports' },
  ]);

  React.useEffect(() => {
    if (!document.getElementById('tsmc-compat')) {
      const s = document.createElement('style');
      s.id = 'tsmc-compat';
      s.textContent = `
html, body, #root, [data-reactroot] { background: #0a1628 !important; }

* { -webkit-tap-highlight-color: transparent; }
html { -webkit-text-size-adjust: 100%; scroll-behavior: smooth; }
input, select, textarea { font-size: 16px !important; min-height: 48px; border-radius: 12px; }
button { min-height: 48px; font-size: 14px; }
@media (max-width: 640px) {
  button, a[role=button] { min-height: 52px; font-size: 15px; }
  input, select, textarea { min-height: 52px; font-size: 17px !important; }
  .text-[13px] { font-size: 13px !important; line-height: 1.5 !important; }
  .text-sm { font-size: 15px !important; line-height: 1.5 !important; }
  .text-base { font-size: 17px !important; }
  .text-lg { font-size: 19px !important; }
  .text-xl { font-size: 22px !important; }
  .text-2xl { font-size: 26px !important; }
  .p-3 { padding: 14px !important; }
  .p-4 { padding: 18px !important; }
  .gap-2 { gap: 10px !important; }
  .gap-3 { gap: 14px !important; }
  .rounded-xl { border-radius: 16px !important; }
  .py-2 { padding-top: 10px !important; padding-bottom: 10px !important; }
  .py-2\\.5 { padding-top: 12px !important; padding-bottom: 12px !important; }
}
`;
      document.head.appendChild(s);
    }
    if (/Line/i.test(navigator.userAgent)) document.documentElement.classList.add('line-browser');
  }, []);

  // Session timer — 30 min auto-logout
  React.useEffect(() => {
    if (showLogin) return;
    setSessionMin(30);
    const interval = setInterval(() => {
      setSessionMin(prev => {
        if (prev <= 1) { setShowLogin(true); setShowProfile(false); setShowNotif(false); return 30; }
        return prev - 1;
      });
    }, 60000);
    // Reset on activity
    const resetTimer = () => setSessionMin(30);
    window.addEventListener('click', resetTimer);
    window.addEventListener('keydown', resetTimer);
    window.addEventListener('touchstart', resetTimer);
    return () => { clearInterval(interval); window.removeEventListener('click', resetTimer); window.removeEventListener('keydown', resetTimer); window.removeEventListener('touchstart', resetTimer); };
  }, [showLogin]);

  const addRecent = React.useCallback((type, label, nav) => {
    const now = new Date();
    const time = now.getHours().toString().padStart(2,'0') + ':' + now.getMinutes().toString().padStart(2,'0');
    setRecentActions(prev => [{ type, label, time, nav }, ...prev].slice(0, 8));
  }, []);
  React.useEffect(() => { window._addRecent = addRecent; return () => { delete window._addRecent; }; }, [addRecent]);

  const safePage = roleNavigation[role].includes(pageKey) ? pageKey : roleNavigation[role][0];

  const handleRoleChange = (r) => {
    setRole(r);
    setPageKey(roleNavigation[r][0]);
  };

  if (showLogin) return <LoginScreen onEnter={() => setShowLogin(false)} />;

  return (
    <div className="min-h-screen text-white" style={{background:"#0a1628",minHeight:"100vh",position:"relative"}}>
      {/* Top bar */}
      <header className="sticky top-0 z-40" style={{background:'rgba(10,22,40,0.85)',backdropFilter:'blur(16px)',borderBottom:'1px solid rgba(255,255,255,0.04)'}}>
        <div className="px-3 lg:px-4 py-2 flex items-center gap-3">
          {/* TSMC Logo + Full Name */}
          <div className="flex items-center gap-2.5 shrink-0">
            <div style={{width:34,height:34,borderRadius:10,background:'linear-gradient(135deg,#FBBF24,#F59E0B)',display:'flex',alignItems:'center',justifyContent:'center',boxShadow:'0 2px 8px rgba(251,191,36,0.25)'}}>
              <svg viewBox="0 0 24 24" width="18" height="18"><path d="M12 2L3 7v6c0 5.25 3.83 10.15 9 11.25C17.17 23.15 21 18.25 21 13V7l-9-5z" fill="#1a1a1a" opacity="0.9"/><path d="M12 4.5L5 8.5v5c0 4.2 3 8.1 7 9 4-0.9 7-4.8 7-9v-5L12 4.5z" fill="none" stroke="#1a1a1a" strokeWidth="0.5"/><path d="M12 8v4m0 2v1" stroke="#F59E0B" strokeWidth="2" strokeLinecap="round"/><circle cx="12" cy="16" r="0.5" fill="#F59E0B"/></svg>
            </div>
            <div className="hidden sm:block">
              <p style={{fontSize:14,fontWeight:800,color:'#FBBF24',margin:0,lineHeight:1.1,letterSpacing:0.5}}>TSMC</p>
              <p style={{fontSize:10,color:'rgba(255,255,255,0.35)',margin:0,lineHeight:1.2}}>Transport Safety Management Center</p>
            </div>
          </div>

          {/* Divider */}
          <div style={{width:1,height:24,background:'rgba(255,255,255,0.08)'}} className="hidden sm:block" />

          {/* Breadcrumb — current page */}
          <div className="flex items-center gap-1.5 flex-1 min-w-0">
            <span className="text-[13px] text-neutral-500 hidden sm:inline">{roleMeta[role].label}</span>
            <span className="text-neutral-600 hidden sm:inline">/</span>
            <span className="text-[13px] text-yellow-400 font-medium truncate">{menuCatalog[showProfilePage ? 'dashboard' : safePage]?.label || 'หน้าหลัก'}</span>
          </div>

          {/* Role switcher — compact pills */}
          <div className="flex gap-0.5 p-0.5 rounded-lg" style={{background:'rgba(255,255,255,0.03)',border:'1px solid rgba(255,255,255,0.05)'}}>
            {Object.entries(roleMeta).map(([key, meta]) => (
              <button key={key} onClick={() => handleRoleChange(key)}
                className={cn('flex items-center gap-1 px-2.5 py-1.5 rounded-md text-[13px] font-medium transition-all duration-200 cursor-pointer',
                  role === key ? 'text-neutral-900' : 'text-neutral-500 hover:text-white hover:bg-white/[0.05]')}
                style={role === key ? {background:'linear-gradient(135deg,#FBBF24,#F59E0B)',boxShadow:'0 2px 8px rgba(251,191,36,0.25)'} : {}}>
                <Icon type={meta.icon} className="h-3 w-3" />
                <span className="hidden lg:inline">{meta.label}</span>
              </button>
            ))}
          </div>

          {/* Right actions */}
          <div className="flex items-center gap-1.5">
            {/* Search button */}
            <button className="h-8 w-8 rounded-lg flex items-center justify-center hover:bg-white/[0.06] cursor-pointer transition-colors" title="ค้นหา">
              <svg viewBox="0 0 24 24" fill="none" className="h-4 w-4 text-neutral-500" stroke="currentColor" strokeWidth="1.8"><circle cx="11" cy="11" r="7"/><path d="m16.5 16.5 4 4" strokeLinecap="round"/></svg>
            </button>
            {/* Notification bell */}
            <div className="relative">
              <button onClick={() => { setShowNotif(v => !v); setShowProfile(false); }}
                className="h-9 w-9 rounded-xl flex items-center justify-center cursor-pointer relative transition-all duration-200"
                style={{background:showNotif?'rgba(251,191,36,0.1)':'transparent'}}
                onMouseEnter={e=>{e.currentTarget.style.background='rgba(255,255,255,0.06)';}}
                onMouseLeave={e=>{e.currentTarget.style.background=showNotif?'rgba(251,191,36,0.1)':'transparent';}}>
                <Icon type="bell" className="h-4.5 w-4.5" style={{color:showNotif?'#FBBF24':'rgba(255,255,255,0.5)'}} />
                {getNotifications(role).filter(n => !dismissedNotifs.includes(n.id)).length > 0 && (
                  <NotifBadge count={getNotifications(role).filter(n => !dismissedNotifs.includes(n.id)).length} />
                )}
              </button>
              <NotifPanel role={role} show={showNotif} onClose={() => setShowNotif(false)}
                dismissed={dismissedNotifs} onDismiss={(id) => setDismissedNotifs(prev => [...prev, id])}
                onNavigate={(key) => { setPageKey(key); setShowNotif(false); }} />
            </div>
            {/* Profile */}
            <ProfileDropdown role={role} show={showProfile} onToggle={() => setShowProfile((v) => !v)} onLogout={() => { setShowLogin(true); setShowProfile(false); setShowNotif(false); setSessionMin(30); }} sessionMin={sessionMin} onProfilePage={() => { setShowProfilePage(true); setShowProfile(false); }} />
          </div>
        </div>
      </header>

      <div className="flex" style={{minHeight:"calc(100vh - 48px)"}}>
        <Sidebar role={role} activeKey={showProfilePage ? '__profile__' : safePage} onChange={(key) => { setPageKey(key); setShowProfilePage(false); }} recentActions={recentActions} open={sidebarOpen} onToggle={() => setSidebarOpen(v => !v)} />

        <main className="flex-1 min-w-0 overflow-y-auto bg-[#080e1c]">
          <div className="max-w-[1000px] mx-auto px-4 lg:px-6 py-5 pb-20 md:pb-6">
            {showProfilePage ? (
              <ProfilePage role={role} onBack={() => setShowProfilePage(false)} userScore={180} />
            ) : (
              <PageContent role={role} pageKey={safePage} setupStep={setupStep} setSetupStep={setSetupStep} />
            )}
          </div>
        </main>
      </div>

      {/* Mobile Bottom Nav */}
      <nav className="md:hidden fixed z-50" style={{bottom:8,left:12,right:12,borderRadius:20,background:'rgba(10,22,40,0.92)',backdropFilter:'blur(16px)',border:'1px solid rgba(255,255,255,0.06)',boxShadow:'0 8px 32px rgba(0,0,0,0.4)'}}>
        <div className="flex items-center justify-around h-14">
          {(roleNavigation[role] || []).slice(0, 5).map(key => {
            const item = menuCatalog[key];
            if (!item) return null;
            const active = key === safePage;
            return (
              <button key={key} onClick={() => setPageKey(key)}
                className={cn('flex flex-col items-center justify-center flex-1 h-full cursor-pointer transition-colors', active ? 'text-yellow-400' : 'text-neutral-500')}>
                <Icon type={item.icon} className={cn('h-5 w-5', active ? 'text-yellow-400' : 'text-neutral-500')} />
                <span className={cn('text-[13px] mt-1 font-medium', active ? 'text-yellow-400 font-bold' : 'text-neutral-600')}>{item.label.length > 6 ? item.label.slice(0,5)+'..' : item.label}</span>
                {active && <div className="absolute top-0 w-6 h-0.5 rounded-full bg-yellow-400" />}
              </button>
            );
          })}
        </div>
      </nav>
    </div>
  );
}
