<?php
require_once __DIR__ . '/lib.php';

correo_seed_admin();
correo_log_boot(array('page' => 'index', 'default_mailbox' => correo_default_mailbox(), 'mailboxes' => array_map(function ($m) { return $m['assigned_email'] ?? ($m['email'] ?? ''); }, correo_mailboxes())));

$user = correo_current_user();
$oneSignalAppId = iqmaximo_config('IQMAXIMO_ONESIGNAL_APP_ID', '');
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Panel de Correo</title>
  <!-- PWA & Apple iOS Support -->
  <link rel="manifest" href="manifest.json">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
  <meta name="apple-mobile-web-app-title" content="Correo IQ">
  <link rel="apple-touch-icon" href="/assets/images/favicon.png">
  <?php if ($oneSignalAppId !== ''): ?>
  <script src="https://cdn.onesignal.com/sdks/web/v16/OneSignalSDK.page.js" defer></script>
  <?php endif; ?>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --bg-main: #070b13;
      --bg-panel: #0b0f19;
      --bg-sidebar: #090e17;
      --bg-card: #0d1321;
      --bg-card-hover: #162235;
      --border-color: #1e293b;
      --text-primary: #cbd5e1;
      --text-secondary: #94a3b8;
      --text-white: #ffffff;
      --accent-gradient: linear-gradient(135deg, #a855f7 0%, #6366f1 50%, #3b82f6 100%);
      --accent-color: #3b82f6;
      --accent-light: rgba(59, 130, 246, 0.1);
      --color-green: #10b981;
      --color-orange: #f59e0b;
      --color-purple: #8b5cf6;
      --color-red: #ef4444;
      --shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Inter', sans-serif;
    }

    body {
      background-color: var(--bg-main);
      color: var(--text-secondary);
      overflow: hidden;
      height: 100vh;
      display: flex;
      flex-direction: column;
    }

    .wrap {
      display: flex;
      flex-direction: column;
      height: 100vh;
      width: 100vw;
      overflow: hidden;
    }

    /* Login Page Styling */
    .wrap.login-page {
      background-color: var(--bg-main);
      align-items: center;
      justify-content: center;
      overflow: auto;
    }

    .login-card {
      background-color: var(--bg-panel);
      border: 1px solid var(--border-color);
      border-radius: 20px;
      width: 100%;
      max-width: 460px;
      padding: 40px;
      box-shadow: var(--shadow);
    }

    .login-title {
      color: var(--text-white);
      font-size: 24px;
      font-weight: 600;
      margin-bottom: 24px;
      text-align: center;
    }

    .login-group {
      margin-bottom: 20px;
    }

    .login-label {
      display: block;
      color: var(--text-secondary);
      font-size: 13px;
      margin-bottom: 8px;
      font-weight: 500;
    }

    .login-input-wrap {
      position: relative;
      display: flex;
      align-items: center;
    }

    .login-icon {
      position: absolute;
      left: 16px;
      color: var(--text-secondary);
      pointer-events: none;
      font-size: 16px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .login-input {
      width: 100%;
      background-color: #111a27;
      color: var(--text-white);
      border: 1px solid var(--border-color);
      padding: 14px 16px 14px 46px;
      border-radius: 12px;
      font-size: 14px;
      outline: none;
      transition: all 0.2s ease;
    }

    .login-input::placeholder {
      color: #4b5e78;
    }

    .login-input:focus {
      border-color: var(--accent-color);
      box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
    }

    .login-submit {
      width: 100%;
      background: var(--accent-gradient);
      color: var(--bg-main);
      border: none;
      padding: 14px;
      border-radius: 12px;
      font-weight: 700;
      font-size: 15px;
      cursor: pointer;
      margin-top: 10px;
      transition: opacity 0.2s ease;
      box-shadow: 0 4px 12px rgba(99, 102, 241, 0.25);
    }

    .login-submit:hover {
      opacity: 0.9;
    }

    .login-note {
      margin-top: 24px;
      font-size: 12px;
      color: var(--text-secondary);
      border-top: 1px solid var(--border-color);
      padding-top: 16px;
      display: flex;
      gap: 10px;
      line-height: 1.5;
    }

    .login-note svg {
      flex-shrink: 0;
      color: var(--text-secondary);
      margin-top: 2px;
    }

    .login-note code {
      background-color: var(--bg-main);
      padding: 2px 6px;
      border-radius: 4px;
      color: var(--text-primary);
      font-family: monospace;
      border: 1px solid var(--border-color);
    }

    .login-error {
      color: var(--color-red);
      font-size: 13px;
      margin-top: 8px;
      text-align: center;
      display: none;
    }

    /* App Shell styling */
    .app-shell-new {
      display: flex;
      flex-direction: column;
      height: 100vh;
      width: 100vw;
      overflow: hidden;
    }

    .top-bar {
      height: 70px;
      background-color: var(--bg-panel);
      border-bottom: 1px solid var(--border-color);
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 0 24px;
      flex-shrink: 0;
      gap: 16px;
    }

    .top-bar .left-section {
      display: flex;
      align-items: center;
      gap: 16px;
      flex-shrink: 0;
    }

    .top-bar .brand {
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .top-bar .brand-icon-box {
      background: var(--accent-gradient);
      color: white;
      width: 36px;
      height: 36px;
      border-radius: 10px;
      display: grid;
      place-items: center;
      font-size: 18px;
      box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
    }

    .top-bar .brand-text h3 {
      font-size: 15px;
      color: var(--text-white);
      font-weight: 600;
    }

    .top-bar .brand-text span {
      font-size: 11px;
      color: var(--text-secondary);
    }

    .top-bar .center-section {
      flex: 1;
      max-width: 480px;
      min-width: 150px;
    }

    .top-bar .search-container {
      position: relative;
      display: flex;
      align-items: center;
    }

    .top-bar .search-icon {
      position: absolute;
      left: 16px;
      color: var(--text-secondary);
    }

    .top-bar .search-container input {
      width: 100%;
      background-color: #111a27;
      border: 1px solid var(--border-color);
      color: var(--text-white);
      padding: 10px 16px 10px 44px;
      border-radius: 10px;
      font-size: 13px;
      outline: none;
      transition: all 0.2s ease;
    }

    .top-bar .search-container input::placeholder {
      color: #4b5e78;
    }

    .top-bar .search-container input:focus {
      border-color: var(--accent-color);
      background-color: var(--bg-card);
    }

    .top-bar .shortcut-badge {
      position: absolute;
      right: 16px;
      background-color: var(--border-color);
      color: var(--text-secondary);
      font-size: 10px;
      padding: 2px 6px;
      border-radius: 4px;
      font-family: monospace;
    }

    .top-bar .right-section {
      display: flex;
      align-items: center;
      gap: 16px;
      flex-shrink: 0;
    }

    .icon-btn {
      background: none;
      border: none;
      color: var(--text-secondary);
      font-size: 18px;
      cursor: pointer;
      width: 38px;
      height: 38px;
      border-radius: 10px;
      display: grid;
      place-items: center;
      transition: all 0.2s ease;
    }

    .icon-btn:hover {
      background-color: rgba(255, 255, 255, 0.05);
      color: var(--text-white);
    }

    .user-profile {
      display: flex;
      align-items: center;
      gap: 12px;
      border-left: 1px solid var(--border-color);
      padding-left: 20px;
      position: relative;
      cursor: pointer;
    }

    .user-info {
      display: flex;
      flex-direction: column;
      align-items: flex-end;
    }

    .user-info .username {
      font-size: 13px;
      color: var(--text-white);
      font-weight: 500;
    }

    .user-info .user-role {
      font-size: 11px;
      color: var(--text-secondary);
    }

    .user-avatar {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      background: linear-gradient(135deg, #a855f7, #6366f1);
      color: white;
      display: grid;
      place-items: center;
      font-weight: 700;
      font-size: 14px;
    }

    /* Profile Dropdown Menu */
    .profile-dropdown {
      position: absolute;
      top: calc(100% + 10px);
      right: 0;
      width: 220px;
      background-color: var(--bg-panel);
      border: 1px solid var(--border-color);
      border-radius: 12px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);
      padding: 8px 0;
      z-index: 1000;
      display: none;
      opacity: 0;
      transform: translateY(-10px);
      transition: opacity 0.15s ease, transform 0.15s ease;
    }

    .profile-dropdown.show {
      display: block;
      opacity: 1;
      transform: translateY(0);
    }

    .dropdown-header {
      padding: 12px 16px;
      display: flex;
      flex-direction: column;
      gap: 4px;
    }

    .dropdown-username {
      font-size: 13px;
      font-weight: 600;
      color: var(--text-white);
      word-break: break-all;
    }

    .dropdown-role {
      font-size: 11px;
      color: var(--text-secondary);
    }

    .dropdown-divider {
      height: 1px;
      background-color: var(--border-color);
      margin: 8px 0;
    }

    .dropdown-item {
      width: 100%;
      background: none;
      border: none;
      padding: 10px 16px;
      display: flex;
      align-items: center;
      gap: 10px;
      color: var(--text-secondary);
      font-size: 13px;
      cursor: pointer;
      text-align: left;
      transition: all 0.2s ease;
    }

    .dropdown-item:hover {
      background-color: rgba(255, 255, 255, 0.05);
      color: var(--text-white);
    }

    /* Main Shell */
    .main-container {
      display: flex;
      flex: 1;
      height: calc(100vh - 70px);
      overflow: hidden;
      position: relative;
    }

    .sidebar-new {
      width: 260px;
      background-color: var(--bg-sidebar);
      border-right: 1px solid var(--border-color);
      display: flex;
      flex-direction: column;
      flex-shrink: 0;
      padding: 20px 12px 40px 12px; /* Aumentado padding inferior para evitar cortes */
      overflow-y: auto;
      transition: width 0.25s cubic-bezier(0.4, 0, 0.2, 1), padding 0.25s cubic-bezier(0.4, 0, 0.2, 1);
      -ms-overflow-style: none;  /* IE and Edge */
      scrollbar-width: none;  /* Firefox */
    }

    .sidebar-new::-webkit-scrollbar {
      display: none; /* Chrome, Safari and Opera */
    }

    .star-btn.starred {
      color: #f59e0b !important;
    }

    .sidebar-top {
      margin-bottom: 20px;
    }

    .btn-compose {
      width: 100%;
      background: var(--accent-gradient);
      color: var(--bg-main);
      border: none;
      padding: 12px;
      border-radius: 12px;
      font-weight: 700;
      font-size: 14px;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      box-shadow: 0 4px 14px rgba(99, 102, 241, 0.25);
      transition: all 0.2s ease;
      white-space: nowrap;
      overflow: hidden;
    }

    .btn-compose:hover {
      transform: translateY(-1px);
    }

    .sidebar-nav {
      display: flex;
      flex-direction: column;
      gap: 20px;
      flex: 1;
    }

    .nav-section {
      display: flex;
      flex-direction: column;
      gap: 4px;
      transition: all 0.2s ease;
    }

    .section-title {
      font-size: 11px;
      font-weight: 600;
      letter-spacing: 0.8px;
      color: #4b5e78;
      margin-bottom: 6px;
      padding-left: 12px;
      text-transform: uppercase;
      transition: opacity 0.2s ease;
    }

    .nav-item {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 10px 12px;
      border-radius: 10px;
      background: none;
      border: none;
      color: var(--text-secondary);
      font-size: 13px;
      font-weight: 500;
      cursor: pointer;
      text-align: left;
      transition: all 0.2s ease;
      width: 100%;
      white-space: nowrap;
      overflow: hidden;
    }

    .nav-item i {
      font-size: 15px;
      width: 18px;
      text-align: center;
      flex-shrink: 0;
    }

    .nav-item:hover {
      background-color: rgba(255, 255, 255, 0.03);
      color: var(--text-primary);
    }

    .nav-item.active {
      background-color: rgba(59, 130, 246, 0.1);
      color: var(--accent-color);
    }

    .nav-label {
      transition: opacity 0.2s ease;
    }

    .nav-badge {
      margin-left: auto;
      background-color: #1e293b;
      color: var(--text-primary);
      font-size: 10px;
      font-weight: 700;
      padding: 2px 8px;
      border-radius: 99px;
      transition: opacity 0.2s ease;
    }

    .nav-item.active .nav-badge {
      background-color: var(--accent-color);
      color: white;
    }

    /* Sidebar Search & Date Filters */
    .sidebar-search-box {
      margin-bottom: 8px;
      padding: 0 4px;
      transition: opacity 0.2s ease;
    }

    .sidebar-input {
      width: 100%;
      background-color: #111a27;
      border: 1px solid var(--border-color);
      color: var(--text-white);
      padding: 8px 12px;
      border-radius: 8px;
      font-size: 12px;
      outline: none;
    }

    .sidebar-date-filter {
      display: flex;
      flex-direction: column;
      gap: 10px;
      padding: 0 4px;
      transition: opacity 0.2s ease;
    }

    .checkbox-container {
      display: flex;
      align-items: center;
      position: relative;
      padding-left: 26px;
      cursor: pointer;
      font-size: 12px;
      color: var(--text-secondary);
      user-select: none;
    }

    .checkbox-container input {
      position: absolute;
      opacity: 0;
      cursor: pointer;
      height: 0;
      width: 0;
    }

    .checkmark {
      position: absolute;
      left: 0;
      height: 16px;
      width: 16px;
      background-color: #111a27;
      border: 1px solid var(--border-color);
      border-radius: 4px;
    }

    .checkbox-container:hover input ~ .checkmark {
      background-color: #162235;
    }

    .checkbox-container input:checked ~ .checkmark {
      background-color: var(--accent-color);
      border-color: var(--accent-color);
    }

    .checkmark:after {
      content: "";
      position: absolute;
      display: none;
    }

    .checkbox-container input:checked ~ .checkmark:after {
      display: block;
    }

    .checkbox-container .checkmark:after {
      left: 5px;
      top: 2px;
      width: 4px;
      height: 8px;
      border: solid white;
      border-width: 0 2px 2px 0;
      transform: rotate(45deg);
    }

    .date-select-wrapper {
      position: relative;
      display: flex;
      align-items: center;
    }

    .date-icon {
      position: absolute;
      left: 12px;
      color: var(--text-secondary);
      font-size: 13px;
      pointer-events: none;
    }

    .sidebar-select {
      width: 100%;
      background-color: #111a27;
      border: 1px solid var(--border-color);
      color: var(--text-primary);
      padding: 8px 12px 8px 34px;
      border-radius: 8px;
      font-size: 12px;
      outline: none;
      appearance: none;
    }

    .btn-clear-filters {
      background: none;
      border: 1px solid var(--border-color);
      color: var(--text-secondary);
      padding: 8px;
      border-radius: 8px;
      font-size: 11px;
      font-weight: 600;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
      transition: all 0.2s ease;
    }

    .btn-clear-filters:hover {
      background-color: rgba(255, 255, 255, 0.03);
      color: var(--text-white);
    }

    /* Storage Card */
    .storage-section {
      background-color: rgba(255, 255, 255, 0.01);
      border: 1px solid var(--border-color);
      border-radius: 12px;
      padding: 12px;
      margin-top: 10px;
      transition: all 0.2s ease;
    }

    .storage-info {
      display: flex;
      justify-content: space-between;
      font-size: 11px;
      margin-bottom: 6px;
    }

    .storage-text strong {
      color: var(--text-white);
    }

    .storage-pct {
      color: var(--text-white);
      font-weight: 600;
    }

    .progress-bar {
      height: 6px;
      background-color: #111a27;
      border-radius: 3px;
      overflow: hidden;
    }

    .progress-fill {
      height: 100%;
      background: linear-gradient(90deg, #a855f7, #3b82f6);
      border-radius: 3px;
    }

    .sidebar-footer {
      margin-top: 24px; /* Asegura un margen físico mínimo superior */
      border-top: 1px solid var(--border-color);
      padding-top: 16px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 8px;
      overflow: hidden;
      flex-shrink: 0; /* Evita que el footer se aplaste */
    }

    .footer-btn {
      background: none;
      border: none;
      color: var(--text-secondary);
      cursor: pointer;
      font-size: 16px;
      display: flex;
      align-items: center;
      gap: 8px;
      transition: color 0.2s ease;
      white-space: nowrap;
    }

    .footer-btn:hover {
      color: var(--text-white);
    }

    .logout-trigger {
      font-size: 12px;
      font-weight: 500;
    }

    /* Sidebar Colapsada en Escritorio */
    .main-container.sidebar-collapsed .sidebar-new {
      width: 70px;
      padding: 20px 8px 40px 8px;
    }

    .main-container.sidebar-collapsed .sidebar-new .btn-compose {
      padding: 12px 0;
      width: 44px;
      height: 44px;
      margin: 0 auto;
      border-radius: 50%;
    }

    .main-container.sidebar-collapsed .sidebar-new .btn-compose i {
      font-size: 16px;
      margin: 0;
    }

    .main-container.sidebar-collapsed .sidebar-new .btn-compose span {
      display: none;
    }

    .main-container.sidebar-collapsed .sidebar-new .section-title,
    .main-container.sidebar-collapsed .sidebar-new .nav-label,
    .main-container.sidebar-collapsed .sidebar-new .nav-badge,
    .main-container.sidebar-collapsed .sidebar-new .sidebar-search-box,
    .main-container.sidebar-collapsed .sidebar-new .sidebar-date-filter,
    .main-container.sidebar-collapsed .sidebar-new .storage-section,
    .main-container.sidebar-collapsed .sidebar-new #sidebarUsers {
      display: none;
      opacity: 0;
    }

    .main-container.sidebar-collapsed .sidebar-new .nav-item {
      justify-content: center;
      padding: 12px 0;
      width: 44px;
      height: 44px;
      margin: 2px auto;
      border-radius: 50%;
    }

    .main-container.sidebar-collapsed .sidebar-new .sidebar-footer {
      flex-direction: column;
      gap: 16px;
      padding-top: 12px;
    }

    .main-container.sidebar-collapsed .sidebar-new .logout-trigger {
      width: 44px;
      height: 44px;
      justify-content: center;
      border-radius: 50%;
      padding: 0;
    }

    .main-container.sidebar-collapsed .sidebar-new .logout-trigger span {
      display: none;
    }

    /* Center Pane */
    .center-pane {
      background-color: var(--bg-panel);
      border-right: 1px solid var(--border-color);
      display: flex;
      flex-direction: column;
      overflow: hidden; 
      transition: width 0.3s ease;
    }

    #tab-inbox, #tab-sent, #tab-compose, #tab-users {
      height: 100%;
      display: flex;
      flex-direction: column;
      overflow: hidden; 
    }

    .pane-header {
      padding: 20px;
      border-bottom: 1px solid var(--border-color);
      display: flex;
      flex-direction: column;
      gap: 12px;
      flex-shrink: 0;
    }

    .pane-header h2 {
      font-size: 18px;
      color: var(--text-white);
      font-weight: 600;
    }

    .pane-header .subtitle {
      font-size: 11px;
      color: var(--text-secondary);
    }

    .actions-area {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .checkbox-dropdown {
      display: flex;
      align-items: center;
      background-color: #111a27;
      border: 1px solid var(--border-color);
      border-radius: 6px;
      padding: 6px 10px;
    }

    .master-checkbox {
      cursor: pointer;
    }

    .dropdown-arrow {
      background: none;
      border: none;
      color: var(--text-secondary);
      font-size: 8px;
      margin-left: 6px;
      cursor: pointer;
    }

    .refresh-btn {
      background-color: #111a27;
      border: 1px solid var(--border-color);
      color: var(--text-secondary);
      width: 32px;
      height: 32px;
      border-radius: 6px;
      cursor: pointer;
      display: grid;
      place-items: center;
      transition: all 0.2s ease;
    }

    .refresh-btn:hover {
      background-color: var(--bg-card);
      color: var(--text-white);
    }

    .pane-select {
      flex: 1;
      background-color: #111a27;
      border: 1px solid var(--border-color);
      color: var(--text-primary);
      padding: 6px 10px;
      border-radius: 6px;
      font-size: 12px;
      outline: none;
    }

    .email-list {
      display: flex;
      flex-direction: column;
      flex: 1;
      overflow-y: auto; 
    }

    /* Email cards */
    .email-item-card {
      display: flex;
      padding: 16px 20px;
      border-bottom: 1px solid var(--border-color);
      cursor: pointer;
      background-color: transparent;
      transition: background-color 0.2s ease;
      position: relative;
    }

    .email-item-card:hover {
      background-color: rgba(255, 255, 255, 0.02);
    }

    .email-item-card.active-card {
      background-color: rgba(59, 130, 246, 0.05);
    }

    .email-item-card.active-card::before {
      content: "";
      position: absolute;
      left: 0;
      top: 0;
      bottom: 0;
      width: 3px;
      background-color: var(--accent-color);
    }

    .card-checkbox-area {
      display: flex;
      align-items: flex-start;
      padding-top: 1px;
      margin-right: 14px;
    }

    .email-checkbox {
      cursor: pointer;
      width: 15px;
      height: 15px;
    }

    .card-avatar {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      color: white;
      font-weight: 700;
      font-size: 13px;
      display: grid;
      place-items: center;
      flex-shrink: 0;
      margin-right: 14px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    }

    .card-content {
      flex: 1;
      min-width: 0;
      display: flex;
      flex-direction: column;
      gap: 4px;
    }

    .card-header-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .sender-name {
      font-size: 13px;
      font-weight: 600;
      color: var(--text-white);
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
      max-width: 70%;
    }

    .card-date {
      font-size: 11px;
      color: var(--text-secondary);
    }

    .card-subject-row {
      display: flex;
    }

    .card-subject {
      font-size: 12px;
      font-weight: 600;
      color: var(--text-primary);
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
    }

    .card-snippet-row {
      display: flex;
    }

    .card-snippet {
      font-size: 11px;
      color: var(--text-secondary);
      line-height: 1.45;
      overflow: hidden;
      text-overflow: ellipsis;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      white-space: pre-wrap;
    }

    .card-footer-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-top: 4px;
    }

    .card-badge {
      font-size: 9px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      padding: 2px 8px;
      border-radius: 4px;
    }

    .card-badge.received {
      background-color: rgba(59, 130, 246, 0.15);
      color: var(--accent-color);
    }

    .card-badge.read {
      background-color: rgba(16, 185, 129, 0.15);
      color: var(--color-green);
    }

    .star-btn {
      background: none;
      border: none;
      color: var(--text-secondary);
      cursor: pointer;
      font-size: 12px;
      transition: color 0.2s ease;
    }

    .star-btn:hover {
      color: var(--color-orange);
    }

    .status-message {
      padding: 16px;
      font-size: 12px;
      text-align: center;
      color: var(--text-secondary);
      border-top: 1px solid var(--border-color);
      background-color: rgba(255, 255, 255, 0.005);
      flex-shrink: 0;
    }

    /* Compose Form */
    .compose-form {
      padding: 24px;
      display: flex;
      flex-direction: column;
      gap: 16px;
      max-width: 900px;
      margin: 0 auto;
      width: 100%;
      overflow-y: auto; 
      flex: 1;
    }

    .form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 16px;
    }

    .form-group {
      display: flex;
      flex-direction: column;
      gap: 8px;
    }

    .form-group label {
      font-size: 12px;
      font-weight: 600;
      color: var(--text-primary);
    }

    .form-input {
      background-color: #111a27;
      border: 1px solid var(--border-color);
      color: var(--text-white);
      padding: 10px 14px;
      border-radius: 8px;
      font-size: 13px;
      outline: none;
    }

    .form-input:focus {
      border-color: var(--accent-color);
    }

    .composer-toolbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .btn-toggle-mode {
      background-color: #111a27;
      border: 1px solid var(--border-color);
      color: var(--text-secondary);
      padding: 4px 10px;
      border-radius: 6px;
      font-size: 11px;
      font-weight: 600;
      cursor: pointer;
    }

    .form-textarea {
      background-color: #111a27;
      border: 1px solid var(--border-color);
      color: var(--text-white);
      padding: 14px;
      border-radius: 8px;
      font-size: 13px;
      min-height: 260px;
      resize: vertical;
      outline: none;
    }

    .form-textarea:focus {
      border-color: var(--accent-color);
    }

    .form-actions {
      display: flex;
      gap: 12px;
      margin-top: 8px;
      flex-shrink: 0;
    }

    .btn-send {
      background: var(--accent-gradient);
      color: var(--bg-main);
      border: none;
      padding: 10px 20px;
      border-radius: 8px;
      font-weight: 700;
      font-size: 13px;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 8px;
      box-shadow: 0 4px 12px rgba(99, 102, 241, 0.2);
    }

    .btn-sample {
      background-color: #111a27;
      border: 1px solid var(--border-color);
      color: var(--text-primary);
      padding: 10px 16px;
      border-radius: 8px;
      font-weight: 600;
      font-size: 13px;
      cursor: pointer;
    }

    /* Mailboxes Admin */
    .users-pane-content {
      padding: 24px;
      max-width: 1000px;
      margin: 0 auto;
      width: 100%;
      overflow-y: auto;
      flex: 1;
    }

    .users-list-container {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
      gap: 18px;
    }

    .mailbox {
      background-color: rgba(255, 255, 255, 0.01);
      border: 1px solid var(--border-color);
      border-radius: 12px;
      padding: 18px;
      display: flex;
      flex-direction: column;
      gap: 10px;
    }

    .mailbox.active {
      border-color: var(--accent-color);
      background-color: rgba(59, 130, 246, 0.02);
    }

    .mailbox .meta {
      display: flex;
      justify-content: space-between;
      align-items: center;
      color: var(--text-white);
      font-size: 14px;
    }

    .mailbox .snippet {
      font-size: 12px;
      color: var(--text-secondary);
    }

    .mailbox .toolbar {
      display: flex;
      gap: 10px;
      margin-top: 10px;
    }

    .mailbox .toolbar .btn {
      flex: 1;
      padding: 8px;
      font-size: 11px;
      border: 1px solid var(--border-color);
      background-color: #111a27;
      border-radius: 6px;
      color: var(--text-primary);
      font-weight: 600;
      cursor: pointer;
    }

    .mailbox .toolbar .btn:hover {
      background-color: var(--bg-card);
      color: var(--text-white);
    }

    /* Detail Pane & Empty state */
    .detail-pane {
      flex: 1;
      background-color: var(--bg-main);
      display: flex;
      flex-direction: column;
      overflow: hidden; 
    }

    .detail-container {
      padding: 24px;
      height: 100%;
      display: flex;
      flex-direction: column;
      overflow: hidden;
    }

    .detail-empty {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 100%;
      text-align: center;
      color: var(--text-secondary);
    }

    .empty-icon {
      font-size: 48px;
      color: var(--border-color);
      margin-bottom: 16px;
    }

    .detail-empty h3 {
      color: var(--text-primary);
      font-size: 16px;
      margin-bottom: 6px;
    }

    .detail-active {
      display: flex;
      flex-direction: column;
      height: 100%;
      overflow: hidden;
    }

    .detail-header {
      border-bottom: 1px solid var(--border-color);
      padding-bottom: 16px;
      margin-bottom: 20px;
      display: flex;
      flex-direction: column;
      gap: 12px;
      flex-shrink: 0;
    }

    .subject-row {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      gap: 16px;
    }

    .subject-row h2 {
      font-size: 20px;
      color: var(--text-white);
      font-weight: 700;
      line-height: 1.35;
    }

    .btn-close-detail {
      background: none;
      border: none;
      color: var(--text-secondary);
      font-size: 16px;
      cursor: pointer;
      padding: 4px;
      transition: color 0.2s ease;
      flex-shrink: 0;
    }

    .btn-close-detail:hover {
      color: var(--text-white);
    }

    .detail-actions-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .status-badge {
      font-size: 10px;
      font-weight: 700;
      text-transform: uppercase;
      padding: 2px 8px;
      border-radius: 4px;
    }

    .status-badge.received {
      background-color: rgba(59, 130, 246, 0.15);
      color: var(--accent-color);
    }

    .status-badge.read {
      background-color: rgba(16, 185, 129, 0.15);
      color: var(--color-green);
    }

    .right-actions {
      display: flex;
      gap: 8px;
    }

    .action-btn {
      background-color: #111a27;
      border: 1px solid var(--border-color);
      color: var(--text-primary);
      width: 34px;
      height: 34px;
      border-radius: 6px;
      cursor: pointer;
      display: grid;
      place-items: center;
      transition: all 0.2s ease;
    }

    .action-btn:hover:not(:disabled) {
      background-color: var(--bg-card);
      color: var(--text-white);
    }

    .action-btn:disabled {
      opacity: 0.4;
      cursor: not-allowed;
    }

    .sender-card {
      display: flex;
      align-items: center;
      gap: 14px;
      background-color: rgba(255, 255, 255, 0.005);
      border: 1px solid var(--border-color);
      border-radius: 12px;
      padding: 16px;
      margin-bottom: 20px;
      flex-shrink: 0;
    }

    .sender-avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background: var(--color-purple);
      color: white;
      font-weight: 700;
      font-size: 15px;
      display: grid;
      place-items: center;
    }

    .sender-details {
      flex: 1;
      min-width: 0;
      display: flex;
      flex-direction: column;
      gap: 4px;
    }

    .name-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .name-row strong {
      font-size: 13px;
      color: var(--text-white);
    }

    .name-row .date {
      font-size: 11px;
      color: var(--text-secondary);
    }

    .recipient-row {
      font-size: 11px;
      color: var(--text-secondary);
    }

    .message-body-wrapper {
      flex: 1;
      background-color: var(--bg-panel);
      border: 1px solid var(--border-color);
      border-radius: 12px;
      padding: 24px;
      overflow-y: auto; 
    }

    .message-body {
      color: var(--text-primary);
      font-size: 14px;
      line-height: 1.6;
    }

    .message-body iframe {
      width: 100%;
      min-height: 460px;
      border: 0;
      border-radius: 8px;
      background-color: #ffffff;
    }

    /* Flex layout layouts */
    .layout-list-active .center-pane {
      width: 440px;
    }
    .layout-list-active .detail-pane {
      display: flex;
    }

    .layout-compose-active .center-pane {
      flex: 1;
    }
    .layout-compose-active .detail-pane {
      display: none;
    }

    .layout-users-active .center-pane {
      flex: 1;
    }
    .layout-users-active .detail-pane {
      display: none;
    }

    #tab-users .row {
      display: none;
    }
    #tab-users #saveUser {
      display: none;
    }

    /* Mobile & Responsive behavior */
    @media (max-width: 1100px) {
      .app-shell-new {
        height: 100vh;
        overflow: hidden;
      }
      .main-container {
        flex-direction: row;
        height: calc(100vh - 70px);
        overflow: hidden;
        position: relative;
      }
      .sidebar-new {
        position: absolute;
        top: 0;
        left: 0;
        bottom: 0;
        width: 260px;
        z-index: 100;
        transform: translateX(-100%);
        transition: transform 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 10px 0 30px rgba(0, 0, 0, 0.5);
      }
      .main-container.sidebar-mobile-open .sidebar-new {
        transform: translateX(0);
      }
      /* Overlay en móvil */
      .sidebar-overlay {
        display: none;
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.6);
        z-index: 99;
      }
      .main-container.sidebar-mobile-open .sidebar-overlay {
        display: block;
      }
      .center-pane {
        width: 100% !important;
        flex: 1;
        height: 100%;
      }
      .detail-pane {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        z-index: 80;
        background-color: var(--bg-main);
        transform: translateX(100%);
        transition: transform 0.25s cubic-bezier(0.4, 0, 0.2, 1);
      }
      .main-container.layout-list-active .detail-pane.detail-open {
        transform: translateX(0);
      }
    }

    /* Responsive header adjustments for squished search bar */
    @media (max-width: 768px) {
      .top-bar .brand-text {
        display: none;
      }
      .top-bar .shortcut-badge {
        display: none;
      }
      .top-bar .center-section {
        margin: 0 10px;
      }
      .top-bar .user-info {
        display: none;
      }
      .top-bar .user-profile {
        border-left: none;
        padding-left: 0;
      }
    }
  </style>
</head>
<body>
  <div class="wrap<?php echo !$user ? ' login-page' : ''; ?>">
    <?php if (!$user): ?>
      <!-- Formulario Login -->
      <div class="login-card">
        <h2 class="login-title">Ingreso al panel</h2>
        <form class="login-form" autocomplete="off" onsubmit="return false;">
          <div class="login-group">
            <label for="loginUser" class="login-label">Usuario</label>
            <div class="login-input-wrap">
              <input type="email" id="loginUser" class="login-input" placeholder="ejemplo@iqmaximo.com" autocomplete="username" value="iqmaximo@gmail.com" required>
              <span class="login-icon" aria-hidden="true">
                <i class="fa-regular fa-envelope"></i>
              </span>
            </div>
          </div>

          <div class="login-group">
            <label for="loginPass" class="login-label">Contraseña</label>
            <div class="login-input-wrap">
              <input type="password" id="loginPass" class="login-input" placeholder="Introduce tu contraseña privada" autocomplete="current-password" required>
              <span class="login-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <rect x="3" y="11" width="18" height="10" rx="2"></rect>
                  <path d="M7 11V8a5 5 0 0 1 10 0v3"></path>
                </svg>
              </span>
            </div>
          </div>

          <button type="button" class="login-submit" id="loginBtn">Entrar</button>
          <div class="status login-error" id="loginStatus"></div>
        </form>

        <div class="login-note">
          <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <circle cx="12" cy="12" r="10"></circle>
            <path d="M12 16v-4"></path>
            <path d="M12 8h.01"></path>
          </svg>
          <span>
            Admin inicial: se crea con <code>IQMAXIMO_CORREO_ADMIN_USER</code> y <code>IQMAXIMO_CORREO_ADMIN_PASS</code>.
          </span>
        </div>
      </div>
      <script>
        const loginApi = async (action, payload = {}) => {
          const response = await fetch('./api.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({action, ...payload})
          });
          return response.json();
        };
        document.getElementById('loginBtn').addEventListener('click', async () => {
          const loginStatus = document.getElementById('loginStatus');
          loginStatus.style.display = 'block';
          loginStatus.textContent = 'Validando...';
          const data = await loginApi('login', {
            username: document.getElementById('loginUser').value,
            password: document.getElementById('loginPass').value
          });
          loginStatus.textContent = data.ok ? 'Acceso concedido. Recargando...' : (data.error || 'No se pudo ingresar.');
          if (data.ok) location.reload();
        });
      </script>
    <?php else: ?>
      <!-- Panel de Correo Shell -->
      <div class="app-shell-new">
        <!-- Cabecera Superior -->
        <header class="top-bar">
          <div class="left-section">
            <button class="icon-btn" id="toggleSidebarBtn" type="button"><i class="fa-solid fa-bars"></i></button>
            <div class="brand">
              <div class="brand-icon-box"><i class="fa-solid fa-envelope"></i></div>
              <div class="brand-text">
                <h3>Correo</h3>
                <span>Panel de correo electrónico</span>
              </div>
            </div>
          </div>
          <div class="center-section">
            <div class="search-container">
              <i class="fa-solid fa-magnifying-glass search-icon"></i>
              <input type="text" id="searchBox" placeholder="Buscar por remitente, destinatario o asunto">
              <span class="shortcut-badge">⌘K</span>
            </div>
          </div>
          <div class="right-section">
            <div class="user-profile" id="userProfileNode">
              <div class="user-info">
                <span class="username"><?php echo htmlspecialchars($user['username'] ?? 'Admin', ENT_QUOTES, 'UTF-8'); ?></span>
                <span class="user-role"><?php echo htmlspecialchars($user['role'] ?? 'Administrador', ENT_QUOTES, 'UTF-8'); ?></span>
              </div>
              <div class="user-avatar">
                <?php echo strtoupper(substr($user['username'] ?? 'A', 0, 1)); ?>
              </div>
              <div class="profile-dropdown" id="profileDropdown">
                <div class="dropdown-header">
                  <span class="dropdown-username"><?php echo htmlspecialchars($user['username'] ?? 'Admin', ENT_QUOTES, 'UTF-8'); ?></span>
                  <span class="dropdown-role"><?php echo htmlspecialchars($user['role'] ?? 'Administrador', ENT_QUOTES, 'UTF-8'); ?></span>
                </div>
                <div class="dropdown-divider"></div>
                <button class="dropdown-item" id="dropdownLogoutBtn" type="button">
                  <i class="fa-solid fa-arrow-right-from-bracket"></i>
                  <span>Cerrar sesión</span>
                </button>
              </div>
            </div>
          </div>
        </header>

        <!-- Contenedor Principal (Tres Columnas) -->
        <div class="main-container layout-list-active">
          <!-- Overlay en móvil -->
          <div class="sidebar-overlay" id="sidebarOverlay"></div>

          <!-- Sidebar Izquierda -->
          <aside class="sidebar-new">
            <div class="sidebar-top">
              <button class="btn-compose tab" data-tab="compose" type="button">
                <i class="fa-solid fa-pen-fancy"></i> <span>Redactar</span>
              </button>
            </div>

            <nav class="sidebar-nav">
              <div class="nav-section">
                <span class="section-title">NAVEGACIÓN</span>
                <button class="nav-item tab active" data-tab="inbox" type="button">
                  <i class="fa-regular fa-envelope"></i>
                  <span class="nav-label">Recibidos</span>
                  <span class="nav-badge" id="inboxBadgeCount">0</span>
                </button>
                <button class="nav-item tab" data-tab="sent" type="button">
                  <i class="fa-regular fa-paper-plane"></i>
                  <span class="nav-label">Enviados</span>
                </button>
                <button class="nav-item tab" data-tab="compose" type="button" style="display:none"></button>
                <button class="nav-item tab" data-tab="draft" type="button">
                  <i class="fa-regular fa-file-lines"></i>
                  <span class="nav-label">Borradores</span>
                </button>
                <?php if (correo_is_admin()): ?>
                <button class="nav-item tab" data-tab="users" type="button">
                  <i class="fa-solid fa-users-viewfinder"></i>
                  <span class="nav-label">Buzones</span>
                </button>
                <?php endif; ?>
              </div>

              <div class="nav-section">
                <span class="section-title">FILTROS</span>
                <button class="nav-item filter-btn" type="button" data-filter="starred"><i class="fa-regular fa-star"></i> <span class="nav-label">Marcados</span></button>
                <button class="nav-item filter-btn" type="button" data-filter="important"><i class="fa-regular fa-bookmark"></i> <span class="nav-label">Importantes</span></button>
                <button class="nav-item filter-btn" type="button" data-filter="archived"><i class="fa-regular fa-folder-open"></i> <span class="nav-label">Archivos</span></button>
              </div>

              <div class="nav-section">
                <span class="section-title">BUSCAR</span>
                <div class="sidebar-search-box">
                  <input type="text" id="sidebarSearchBox" class="sidebar-input" placeholder="Remitente, asunto...">
                </div>
                <div class="sidebar-date-filter">
                  <label class="checkbox-container">
                    <input type="checkbox" id="enableDateFilter" checked>
                    <span class="checkmark"></span>
                    Rango de fechas
                  </label>
                  <div class="date-select-wrapper">
                    <i class="fa-regular fa-calendar date-icon"></i>
                    <select id="sidebarDaysFilter" class="sidebar-select">
                      <option value="15">Últimos 15 días</option>
                      <option value="7">Últimos 7 días</option>
                      <option value="30">Últimos 30 días</option>
                      <option value="90">Últimos 90 días</option>
                      <option value="0">Todo</option>
                    </select>
                  </div>
                  <button class="btn-clear-filters" id="sidebarClearFilters" type="button">
                    <i class="fa-solid fa-arrow-rotate-left"></i> Limpiar filtros
                  </button>
                </div>
              </div>

              <?php if (correo_is_admin()): ?>
              <div class="nav-section">
                <span class="section-title">BUZONES DISPONIBLES</span>
                <div class="sidebar-list" id="sidebarUsers">
                  <!-- Cargado dinámicamente -->
                </div>
              </div>
              <?php endif; ?>

              <div class="nav-section storage-section">
                <span class="section-title">Almacenamiento</span>
                <div class="storage-info">
                  <span class="storage-text"><strong>2.4 GB</strong> de 10 GB usados</span>
                  <span class="storage-pct">24%</span>
                </div>
                <div class="progress-bar">
                  <div class="progress-fill" style="width: 24%"></div>
                </div>
              </div>
            </nav>

            <div class="sidebar-footer">
              <button class="footer-btn" type="button"><i class="fa-solid fa-gear"></i></button>
              <button class="footer-btn logout-trigger" id="logoutBtn" type="button">
                <i class="fa-solid fa-arrow-right-from-bracket"></i> <span>Cerrar sesión</span>
              </button>
            </div>
          </aside>

          <!-- Panel Central (Listas y Formularios) -->
          <section class="center-pane">
            
            <!-- Listado de Recibidos -->
            <div id="tab-inbox">
              <div class="pane-header">
                <div class="title-area">
                  <h2>Recibidos</h2>
                  <span class="subtitle" id="inboxCountLabel">0 correos electrónicos</span>
                </div>
                <div class="actions-area">
                  <div class="checkbox-dropdown">
                    <input type="checkbox" class="master-checkbox">
                    <button class="dropdown-arrow" type="button"><i class="fa-solid fa-chevron-down"></i></button>
                  </div>
                  <button class="refresh-btn" id="reloadInbox" type="button"><i class="fa-solid fa-rotate-right"></i></button>
                  <select id="daysFilter" class="pane-select">
                    <option value="15">Últimos 15 días</option>
                    <option value="7">Últimos 7 días</option>
                    <option value="30">Últimos 30 días</option>
                    <option value="90">Últimos 90 días</option>
                    <option value="0">Todo</option>
                  </select>
                  <button class="btn-clear-filters" id="clearFilters" type="button" style="display:none"></button>
                </div>
              </div>
              <div class="email-list" id="inboxList"></div>
              <div class="status-message" id="inboxStatus"></div>
            </div>

            <!-- Listado de Enviados -->
            <div id="tab-sent" style="display:none">
              <div class="pane-header">
                <div class="title-area">
                  <h2>Enviados</h2>
                  <span class="subtitle" id="sentCountLabel">0 correos electrónicos</span>
                </div>
                <div class="actions-area">
                  <div class="checkbox-dropdown">
                    <input type="checkbox" class="master-checkbox">
                    <button class="dropdown-arrow" type="button"><i class="fa-solid fa-chevron-down"></i></button>
                  </div>
                  <button class="refresh-btn" id="reloadSent" type="button"><i class="fa-solid fa-rotate-right"></i></button>
                </div>
              </div>
              <div class="email-list" id="sentList"></div>
              <div class="status-message" id="sentStatus"></div>
            </div>

            <!-- Compositor de Correo Nuevo -->
            <div id="tab-compose" style="display:none">
              <div class="pane-header">
                <div class="title-area">
                  <h2>Nuevo Correo</h2>
                  <span class="subtitle">Buzón activo: <strong id="activeMailboxLabel"><?php echo htmlspecialchars(correo_default_mailbox(), ENT_QUOTES, 'UTF-8'); ?></strong></span>
                </div>
              </div>
              <div class="compose-form">
                <div class="form-row">
                  <div class="form-group">
                    <label for="fromEmail">Desde</label>
                    <input type="text" id="fromEmail" class="form-input" placeholder="no-reply@iqmaximo.com">
                  </div>
                  <div class="form-group">
                    <label for="toEmail">Para</label>
                    <input type="text" id="toEmail" class="form-input" placeholder="destino@dominio.com">
                  </div>
                </div>
                <div class="form-group">
                  <label for="subject">Asunto</label>
                  <input type="text" id="subject" class="form-input" placeholder="Asunto del correo">
                </div>
                <div class="form-group">
                  <div class="composer-toolbar">
                    <label id="composeLabel">Mensaje</label>
                    <button class="btn-toggle-mode" id="toggleComposeMode" type="button">Ver HTML</button>
                  </div>
                  <textarea id="html" class="form-textarea" placeholder="Escribe tu mensaje aquí..."></textarea>
                </div>
                <div class="form-actions">
                  <button class="btn-send" id="sendEmail" type="button"><i class="fa-regular fa-paper-plane"></i> Enviar correo</button>
                  <button class="btn-sample" id="fillSample" type="button">Cargar ejemplo</button>
                </div>
                <div class="status-message" id="sendStatus"></div>
              </div>
            </div>

            <!-- Buzones (Gestión) -->
            <?php if (correo_is_admin()): ?>
            <div id="tab-users" style="display:none">
              <div class="pane-header">
                <div class="title-area">
                  <h2>Buzones Disponibles</h2>
                  <span class="subtitle">Gestionar historial e importaciones</span>
                </div>
                <div class="actions-area">
                  <button class="refresh-btn" id="reloadUsers" type="button"><i class="fa-solid fa-rotate-right"></i></button>
                </div>
              </div>
              <div class="users-pane-content">
                <!-- Inputs requeridos por el JS en su flujo -->
                <div class="row">
                  <input id="newUsername" type="hidden">
                  <input id="newUserEmail" type="hidden">
                  <input id="newAssignedEmail" type="hidden">
                  <input id="newUserPass" type="hidden">
                  <select id="newUserRole" style="display:none"><option value="user">user</option></select>
                  <button id="saveUser" type="button" style="display:none"></button>
                </div>

                <div class="users-list-container" id="usersList"></div>
                <div class="status-message" id="usersStatus"></div>

                <div style="margin-top:24px; padding:20px; border:1px solid var(--border-color); border-radius:12px; background:rgba(255,255,255,0.005)">
                  <h4 style="color:var(--text-white); margin-bottom:12px">Acción de Importación General</h4>
                  <button class="btn-sample" id="importHistory" type="button">Importar historial</button>
                </div>
              </div>
            </div>
            <?php endif; ?>

          </section>

          <!-- Panel Derecho (Detalle del Correo) -->
          <section class="detail-pane">
            <div class="detail-container">
              <!-- Estado Vacío -->
              <div class="detail-empty" id="detailEmptyState">
                <i class="fa-regular fa-envelope-open empty-icon"></i>
                <h3>Selecciona un correo</h3>
                <p>Aquí verás el contenido completo del mensaje.</p>
              </div>

              <!-- Detalle Activo -->
              <div class="detail-active" id="detailActiveState" style="display:none">
                <div class="detail-header">
                  <div class="subject-row">
                    <h2 id="detailTitle">Asunto del correo</h2>
                    <button class="btn-close-detail" id="closeDetailBtn" type="button" title="Cerrar detalle"><i class="fa-solid fa-xmark"></i></button>
                  </div>
                  <div class="detail-actions-bar">
                    <div class="left-actions">
                      <span class="status-badge" id="detailStatusBadge">recibido</span>
                    </div>
                    <div class="right-actions">
                      <button class="action-btn" id="replyBtn" title="Responder" type="button" disabled><i class="fa-solid fa-reply"></i></button>
                      <button class="action-btn" id="openComposeBtn" title="Editar respuesta" type="button" disabled><i class="fa-solid fa-pen-to-square"></i></button>
                      <button class="action-btn" id="toggleDetailView" title="Ver HTML" type="button" disabled><i class="fa-solid fa-code"></i></button>
                      <button class="action-btn" id="detailStarBtn" title="Marcar con estrella" type="button"><i class="fa-regular fa-star"></i></button>
                      <button class="action-btn" id="detailImportantBtn" title="Marcar como importante" type="button"><i class="fa-regular fa-bookmark"></i></button>
                      <button class="action-btn" id="detailArchiveBtn" title="Archivar" type="button"><i class="fa-regular fa-folder-open"></i></button>
                    </div>
                  </div>
                </div>

                <div class="sender-card">
                  <div class="sender-avatar" id="detailSenderAvatar">M</div>
                  <div class="sender-details">
                    <div class="name-row">
                      <strong id="detailSenderName">Nombre</strong>
                      <span class="date" id="detailDate">Fecha</span>
                    </div>
                    <div class="recipient-row" id="detailMeta">
                      <!-- Renderizado por JS -->
                    </div>
                  </div>
                </div>

                <div class="message-body-wrapper">
                  <div class="message-body" id="detailBody">
                    <!-- Cuerpo del mensaje -->
                  </div>
                </div>
              </div>
            </div>
          </section>
        </div>
      </div>

      <!-- Scripts JS Originales Adaptados -->
      <script>
        const defaultMailbox = '<?php echo htmlspecialchars(correo_default_mailbox(), ENT_QUOTES, "UTF-8"); ?>';
        const state = { inbox: [], sent: [], users: [], activeMailboxEmail: defaultMailbox, importAfter: '', query: '', days: 15, currentDetail: null, currentDetailKind: 'received', currentDetailView: 'text', composeMode: 'text' };
        const $ = (id) => document.getElementById(id);
        const esc = (value) => String(value ?? '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;').replace(/'/g,'&#39;');
        
        const htmlToText = (html) => {
          const wrapper = document.createElement('div');
          wrapper.innerHTML = String(html ?? '');
          return (wrapper.innerText || wrapper.textContent || '').replace(/\u00a0/g, ' ').trim();
        };

        const plainTextToHtml = (text) => {
          const lines = String(text ?? '').replace(/\r\n/g, '\n').split('\n');
          const blocks = lines.map((line) => line.trim() === '' ? '<p></p>' : `<p>${esc(line)}</p>`);
          return `<div style="font-family:Arial,sans-serif;font-size:14px;line-height:1.6;color:#111">${blocks.join('')}</div>`;
        };

        const getAvatarColor = (name) => {
          const colors = ['#8b5cf6', '#10b981', '#f59e0b', '#3b82f6', '#ec4899', '#14b8a6'];
          const charCode = String(name || 'A').charCodeAt(0);
          return colors[charCode % colors.length];
        };

        const getInitial = (name) => {
          return String(name || 'A').charAt(0).toUpperCase();
        };

        const setActiveMailbox = (email) => {
          state.activeMailboxEmail = String(email || '').trim() || defaultMailbox;
          
          // Actualiza todos los labels de buzón activo
          document.querySelectorAll('#activeMailboxLabel').forEach(el => {
            el.textContent = state.activeMailboxEmail;
          });
          
          if ($('fromEmail')) {
            $('fromEmail').value = state.activeMailboxEmail;
          }
        };

        const setComposeMode = (mode, convertValue = false) => {
          state.composeMode = mode === 'html' ? 'html' : 'text';
          if ($('toggleComposeMode')) {
            $('toggleComposeMode').textContent = state.composeMode === 'html' ? 'Vista normal' : 'Ver HTML';
          }
          if ($('composeLabel')) {
            $('composeLabel').textContent = state.composeMode === 'html' ? 'Mensaje HTML' : 'Mensaje';
          }
          if (convertValue && $('html')) {
            $('html').value = state.composeMode === 'html' ? plainTextToHtml($('html').value) : htmlToText($('html').value);
          }
        };

        const parseDate = (value) => {
          if (!value) return null;
          const parsed = new Date(String(value).replace(' ', 'T'));
          return Number.isNaN(parsed.getTime()) ? null : parsed;
        };

        const subjectForReply = (subject) => {
          const clean = String(subject || '').trim();
          if (!clean) return 'Re:';
          if (/^(re|fw)\s*:/i.test(clean)) return clean;
          return 'Re: ' + clean;
        };

        const replyText = (item) => {
          const from = String(item.from || '').trim();
          const to = String(item.to || '').trim();
          const subject = String(item.subject || '').trim();
          const original = htmlToText(item.text || item.html || 'Sin contenido original.');
          return [
            'Hola,',
            '',
            '---',
            'Mensaje original',
            `De: ${from}`,
            `Para: ${to}`,
            `Asunto: ${subject}`,
            '',
            original,
          ].join('\n');
        };

        const renderDetailBody = (item, view = 'text') => {
          if (!item) {
            $('detailBody').innerHTML = '';
            return;
          }
          if (view === 'html') {
            $('detailBody').innerHTML = `<iframe sandbox="allow-popups" srcdoc="${String(item.html || item.text || '<p>Sin contenido.</p>').replace(/"/g,'&quot;')}"></iframe>`;
            return;
          }
          const text = htmlToText(item.text || item.html || 'Sin contenido.');
          $('detailBody').innerHTML = `<div style="white-space:pre-wrap;line-height:1.6;color:var(--text-primary);font-size:13px">${esc(text || 'Sin contenido.')}</div>`;
        };

        async function api(action, payload = {}) {
          const response = await fetch('./api.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ action, ...payload }),
          });
          return response.json();
        }

        // LocalStorage & Filter Helpers
        const getStarredIds = () => JSON.parse(localStorage.getItem('starred_ids') || '[]');
        const getImportantIds = () => JSON.parse(localStorage.getItem('important_ids') || '[]');
        const getArchivedIds = () => JSON.parse(localStorage.getItem('archived_ids') || '[]');

        const saveStarredIds = (ids) => localStorage.setItem('starred_ids', JSON.stringify(ids));
        const saveImportantIds = (ids) => localStorage.setItem('important_ids', JSON.stringify(ids));
        const saveArchivedIds = (ids) => localStorage.setItem('archived_ids', JSON.stringify(ids));

        function toggleStar(id) {
          let ids = getStarredIds();
          if (ids.includes(id)) {
            ids = ids.filter(x => x !== id);
          } else {
            ids.push(id);
          }
          saveStarredIds(ids);
          renderList('inbox');
          renderList('sent');
          if (state.currentDetail && state.currentDetail.id === id) {
            updateDetailActions(state.currentDetail);
          }
        }

        function toggleImportant(id) {
          let ids = getImportantIds();
          if (ids.includes(id)) {
            ids = ids.filter(x => x !== id);
          } else {
            ids.push(id);
          }
          saveImportantIds(ids);
          renderList('inbox');
          renderList('sent');
          if (state.currentDetail && state.currentDetail.id === id) {
            updateDetailActions(state.currentDetail);
          }
        }

        function toggleArchive(id) {
          let ids = getArchivedIds();
          if (ids.includes(id)) {
            ids = ids.filter(x => x !== id);
          } else {
            ids.push(id);
          }
          saveArchivedIds(ids);
          
          if (state.currentDetail && state.currentDetail.id === id) {
            state.currentDetail = null;
            if ($('detailEmptyState')) $('detailEmptyState').style.display = 'flex';
            if ($('detailActiveState')) $('detailActiveState').style.display = 'none';
          }
          renderList('inbox');
          renderList('sent');
        }

        function updateDetailActions(item) {
          if (!item) return;
          const starredIds = getStarredIds();
          const importantIds = getImportantIds();
          const archivedIds = getArchivedIds();

          const isStarred = starredIds.includes(item.id);
          const isImportant = importantIds.includes(item.id);
          const isArchived = archivedIds.includes(item.id);

          const starBtn = $('detailStarBtn');
          if (starBtn) {
            starBtn.innerHTML = isStarred ? '<i class="fa-solid fa-star"></i>' : '<i class="fa-regular fa-star"></i>';
            starBtn.style.color = isStarred ? '#f59e0b' : 'var(--text-primary)';
          }

          const importantBtn = $('detailImportantBtn');
          if (importantBtn) {
            importantBtn.innerHTML = isImportant ? '<i class="fa-solid fa-bookmark"></i>' : '<i class="fa-regular fa-bookmark"></i>';
            importantBtn.style.color = isImportant ? '#a855f7' : 'var(--text-primary)';
          }

          const archiveBtn = $('detailArchiveBtn');
          if (archiveBtn) {
            archiveBtn.innerHTML = isArchived ? '<i class="fa-solid fa-folder-open"></i>' : '<i class="fa-regular fa-folder-open"></i>';
            archiveBtn.style.color = isArchived ? '#10b981' : 'var(--text-primary)';
          }
        }

        function setActiveTab(name) {
          // Actualiza botones con clase tab tanto en el sidebar como en el compositor
          document.querySelectorAll('.tab').forEach((btn) => btn.classList.toggle('active', btn.dataset.tab === name));
          ['inbox','sent','compose','users'].forEach((tab) => { 
            const el = $('tab-' + tab); 
            if (el) el.style.display = tab === name ? 'flex' : 'none'; 
          });

          // Flex layout toggle
          const container = document.querySelector('.main-container');
          if (container) {
            container.className = 'main-container';
            if (name === 'inbox' || name === 'sent') {
              container.classList.add('layout-list-active');
            } else if (name === 'compose') {
              container.classList.add('layout-compose-active');
            } else if (name === 'users') {
              container.classList.add('layout-users-active');
            }
          }
        }

        function filteredItems(type) {
          const query = String(state.query || '').trim().toLowerCase();
          const days = Number(state.days || 0);
          const cutoff = new Date();
          if (days > 0) {
            cutoff.setDate(cutoff.getDate() - days);
          }

          let sourceList = state[type] || [];
          if (state.currentFilter === 'starred' || state.currentFilter === 'important' || state.currentFilter === 'archived') {
            const allItems = [...(state.inbox || []), ...(state.sent || [])];
            const uniqueItemsMap = new Map();
            allItems.forEach(item => {
              if (item && item.id) uniqueItemsMap.set(item.id, item);
            });
            sourceList = Array.from(uniqueItemsMap.values());
          }

          return sourceList.filter((item) => {
            const starredIds = getStarredIds();
            const importantIds = getImportantIds();
            const archivedIds = getArchivedIds();

            if (state.currentFilter === 'starred' && !starredIds.includes(item.id)) return false;
            if (state.currentFilter === 'important' && !importantIds.includes(item.id)) return false;
            if (state.currentFilter === 'archived' && !archivedIds.includes(item.id)) return false;
            
            if (!state.currentFilter && archivedIds.includes(item.id)) return false;

            const haystack = `${item.from || ''} ${item.to || ''} ${item.subject || ''} ${item.preview || item.text || item.html || ''}`.toLowerCase();
            if (query && !haystack.includes(query)) {
              return false;
            }
            if (!days) {
              return true;
            }
            const created = parseDate(item.created_at || '');
            if (!created) {
              return true;
            }
            return created >= cutoff;
          });
        }

        function renderList(type) {
          const list = filteredItems(type);
          const target = $(type + 'List');
          const status = $(type + 'Status');
          
          if (type === 'inbox' && $('inboxCountLabel')) {
            let title = 'Recibidos';
            if (state.currentFilter === 'starred') title = 'Marcados';
            else if (state.currentFilter === 'important') title = 'Importantes';
            else if (state.currentFilter === 'archived') title = 'Archivos';
            
            const titleEl = document.querySelector('#tab-inbox .pane-header .title-area h2');
            if (titleEl) titleEl.textContent = title;

            $('inboxCountLabel').textContent = `${list.length} correos electrónicos`;
            if ($('inboxBadgeCount')) $('inboxBadgeCount').textContent = list.length;
          } else if (type === 'sent' && $('sentCountLabel')) {
            $('sentCountLabel').textContent = `${list.length} correos electrónicos`;
          }

          if (!list.length) { 
            target.innerHTML = '<div style="padding:40px; text-align:center; font-size:13px; color:var(--text-secondary)">Sin datos.</div>'; 
            status.textContent = 'Sin datos.'; 
            return; 
          }

          target.innerHTML = list.map((item, index) => {
            const fromName = item.from || '-';
            const initial = getInitial(fromName);
            const avatarColor = getAvatarColor(fromName);
            
            const isSelected = state.currentDetail && state.currentDetail.id === item.id;
            const activeClass = isSelected ? 'active-card' : '';
            
            const starredIds = getStarredIds();
            const isStarred = starredIds.includes(item.id);
            
            return `
              <div class="item email-item-card ${activeClass}" data-index="${index}">
                <div class="card-checkbox-area">
                  <input type="checkbox" class="email-checkbox" onclick="event.stopPropagation()">
                </div>
                <div class="card-avatar" style="background-color: ${avatarColor}">
                  ${initial}
                </div>
                <div class="card-content">
                  <div class="card-header-row">
                    <span class="sender-name" title="${esc(fromName)}">${esc(fromName)}</span>
                    <span class="card-date">${esc(item.created_at || '')}</span>
                  </div>
                  <div class="card-subject-row">
                    <span class="card-subject">${esc(item.subject || '(sin asunto)')}</span>
                  </div>
                  <div class="card-snippet-row">
                    <p class="card-snippet">${esc((item.preview || item.text || item.html || '').slice(0, 110))}</p>
                  </div>
                  <div class="card-footer-row">
                    <span class="card-badge ${item.status === 'received' ? 'received' : 'read'}">${esc(item.status || type)}</span>
                    <button class="star-btn ${isStarred ? 'starred' : ''}" type="button" onclick="event.stopPropagation(); toggleStar(${item.id})">
                      <i class="${isStarred ? 'fa-solid' : 'fa-regular'} fa-star"></i>
                    </button>
                  </div>
                </div>
              </div>
            `;
          }).join('');
          
          status.textContent = `${list.length} correo(s) cargado(s).`;
        }

        function showDetail(item, kind = 'received') {
          state.currentDetail = item;
          state.currentDetailKind = kind;
          state.currentDetailView = 'text';
          
          if ($('detailEmptyState')) $('detailEmptyState').style.display = item ? 'none' : 'flex';
          if ($('detailActiveState')) $('detailActiveState').style.display = item ? 'flex' : 'none';

          if (item) {
            $('detailTitle').textContent = item.subject || '(sin asunto)';
            $('detailMeta').textContent = `${item.from || '-'} -> ${item.to || '-'}`.trim();
            
            if ($('detailSenderAvatar')) {
              $('detailSenderAvatar').textContent = getInitial(item.from);
              $('detailSenderAvatar').style.backgroundColor = getAvatarColor(item.from);
            }
            if ($('detailSenderName')) $('detailSenderName').textContent = item.from || '-';
            if ($('detailDate')) $('detailDate').textContent = item.created_at || '';
            if ($('detailStatusBadge')) {
              $('detailStatusBadge').textContent = item.status || kind;
              $('detailStatusBadge').className = 'status-badge ' + (item.status === 'received' ? 'received' : 'read');
            }
            
            renderDetailBody(item, state.currentDetailView);
            updateDetailActions(item);
            
            // En móvil, cuando hay detalle cargado, deslizar el panel de detalle hacia la vista
            const detailPane = document.querySelector('.detail-pane');
            if (detailPane) {
              detailPane.classList.add('detail-open');
            }
          } else {
            // Quitar clase abierta en móvil si no hay item
            const detailPane = document.querySelector('.detail-pane');
            if (detailPane) {
              detailPane.classList.remove('detail-open');
            }
          }

          $('replyBtn').disabled = !item;
          $('openComposeBtn').disabled = !item;
          $('toggleDetailView').disabled = !item;
          $('toggleDetailView').textContent = 'Ver HTML';
        }

        async function loadInbox() {
          $('inboxStatus').textContent = 'Cargando...';
          if (<?php echo correo_is_admin() ? 'true' : 'false'; ?> && state.activeMailboxEmail) {
            await loadMailbox(state.activeMailboxEmail);
            return;
          }
          const data = await api('listInbox');
          if (!data.ok) { $('inboxStatus').textContent = data.error || 'No se pudo cargar.'; return; }
          state.inbox = data.items || []; renderList('inbox');
        }

        async function loadSent() {
          $('sentStatus').textContent = 'Cargando...';
          if (<?php echo correo_is_admin() ? 'true' : 'false'; ?> && state.activeMailboxEmail) {
            const data = await api('listMailbox', { kind: 'sent', email: state.activeMailboxEmail });
            if (!data.ok) { $('sentStatus').textContent = data.error || 'No se pudo cargar.'; return; }
            state.sent = data.items || []; renderList('sent');
            return;
          }
          const data = await api('listSent');
          if (!data.ok) { $('sentStatus').textContent = data.error || 'No se pudo cargar.'; return; }
          state.sent = data.items || []; renderList('sent');
        }

        async function loadMailbox(email) {
          if (!email) return;
          setActiveMailbox(email);
          $('inboxStatus').textContent = 'Cargando buzón...';
          $('sentStatus').textContent = 'Cargando buzón...';
          const received = await api('listMailbox', { kind: 'received', email });
          if (!received.ok) { $('inboxStatus').textContent = received.error || 'No se pudo cargar.'; return; }
          state.inbox = received.items || []; renderList('inbox');
          const sent = await api('listMailbox', { kind: 'sent', email });
          if (!sent.ok) { $('sentStatus').textContent = sent.error || 'No se pudo cargar.'; return; }
          state.sent = sent.items || []; renderList('sent');
        }

        async function loadUsers() {
          if (!$('usersList')) return;
          $('usersStatus').textContent = 'Cargando...';
          const data = await api('listUsers');
          if (!data.ok) { $('usersStatus').textContent = data.error || 'No se pudo cargar.'; return; }
          state.users = data.items || [];
          if (!state.activeMailboxEmail && state.users[0]) {
            setActiveMailbox(defaultMailbox || state.users[0].assigned_email || state.users[0].email || '');
          } else if (state.activeMailboxEmail) {
            setActiveMailbox(state.activeMailboxEmail);
          }

          $('usersList').innerHTML = state.users.map((user) => {
            const mailbox = user.assigned_email || user.email || '';
            const active = String(mailbox).toLowerCase() === String(state.activeMailboxEmail || '').toLowerCase();
            return `
              <div class="mailbox ${active ? 'active' : ''}">
                <div class="meta"><span><strong>${esc(user.username || mailbox)}</strong></span><span>${user.active ? 'activo' : 'inactivo'}</span></div>
                <div class="snippet">${esc(user.email || '')}</div>
                <div class="snippet">Historial: ${esc(mailbox)}</div>
                <div class="toolbar">
                  <button class="btn" type="button" data-mailbox="${esc(mailbox)}">Ver historial</button>
                  <button class="btn" type="button" data-import="${esc(mailbox)}">Importar historial</button>
                </div>
              </div>
            `;
          }).join('');

          if ($('sidebarUsers')) {
            $('sidebarUsers').innerHTML = state.users.map((user) => {
              const mailbox = user.assigned_email || user.email || '';
              const active = String(mailbox).toLowerCase() === String(state.activeMailboxEmail || '').toLowerCase();
              return `
                <div class="mailbox ${active ? 'active' : ''}" style="padding:10px; margin-bottom:8px; border-radius:8px">
                  <div class="meta" style="font-size:12px"><span><strong>${esc(user.username || mailbox)}</strong></span></div>
                  <div class="toolbar" style="margin-top:6px; display:flex; gap:6px">
                    <button class="btn" style="flex:1; padding:4px 6px; font-size:10px; cursor:pointer" type="button" data-mailbox="${esc(mailbox)}">Ver</button>
                    <button class="btn" style="flex:1; padding:4px 6px; font-size:10px; cursor:pointer" type="button" data-import="${esc(mailbox)}">Importar</button>
                  </div>
                </div>
              `;
            }).join('');
          }
          $('usersStatus').textContent = `${state.users.length} buzón(es).`;
        }

        async function sendEmail() {
          $('sendStatus').textContent = 'Enviando...';
          const rawBody = $('html').value;
          const data = await api('send', {
            from: ($('fromEmail').value.trim() || state.activeMailboxEmail || defaultMailbox),
            to: $('toEmail').value.trim(),
            subject: $('subject').value.trim(),
            html: state.composeMode === 'html' ? rawBody : plainTextToHtml(rawBody),
          });
          $('sendStatus').textContent = data.ok ? 'Correo enviado.' : (data.error || 'No se pudo enviar.');
          if (data.ok) { await Promise.all([loadInbox(), loadSent()]); }
        }

        // Event listeners
        document.querySelectorAll('.tab').forEach((btn) => btn.addEventListener('click', () => {
          state.currentFilter = null;
          document.querySelectorAll('.filter-btn').forEach((fb) => fb.classList.remove('active'));
          setActiveTab(btn.dataset.tab);
        }));

        // Bind Filter Buttons
        document.querySelectorAll('.filter-btn').forEach((btn) => {
          btn.addEventListener('click', () => {
            const filterName = btn.dataset.filter;
            state.currentFilter = filterName;
            
            setActiveTab('inbox');
            
            document.querySelectorAll('.filter-btn').forEach((fb) => fb.classList.toggle('active', fb.dataset.filter === filterName));
            document.querySelectorAll('.tab').forEach((t) => t.classList.remove('active'));
            document.querySelectorAll('.tab[data-tab="inbox"]').forEach((t) => t.classList.add('active'));

            renderList('inbox');
          });
        });

        // Detail Actions Click Listeners
        const detailStarBtn = $('detailStarBtn');
        if (detailStarBtn) {
          detailStarBtn.addEventListener('click', () => {
            if (state.currentDetail) toggleStar(state.currentDetail.id);
          });
        }

        const detailImportantBtn = $('detailImportantBtn');
        if (detailImportantBtn) {
          detailImportantBtn.addEventListener('click', () => {
            if (state.currentDetail) toggleImportant(state.currentDetail.id);
          });
        }

        const detailArchiveBtn = $('detailArchiveBtn');
        if (detailArchiveBtn) {
          detailArchiveBtn.addEventListener('click', () => {
            if (state.currentDetail) toggleArchive(state.currentDetail.id);
          });
        }
        $('reloadInbox').addEventListener('click', loadInbox);
        $('reloadSent').addEventListener('click', loadSent);
        if ($('sidebarReloadInbox')) $('sidebarReloadInbox').addEventListener('click', loadInbox);
        if ($('sidebarReloadSent')) $('sidebarReloadSent').addEventListener('click', loadSent);
        if ($('sidebarImportHistory')) $('sidebarImportHistory').addEventListener('click', () => { if ($('importHistory')) $('importHistory').click(); });
        if ($('sidebarLogout')) $('sidebarLogout').addEventListener('click', () => { if ($('logoutBtn')) $('logoutBtn').click(); });
        $('sendEmail').addEventListener('click', sendEmail);
        
        $('searchBox').addEventListener('input', (event) => {
          state.query = event.target.value || '';
          renderList('inbox');
          renderList('sent');
        });

        if ($('sidebarSearchBox')) $('sidebarSearchBox').addEventListener('input', (event) => {
          const value = event.target.value || '';
          if ($('searchBox')) $('searchBox').value = value;
          state.query = value;
          renderList('inbox');
          renderList('sent');
        });

        $('daysFilter').addEventListener('change', (event) => {
          state.days = Number(event.target.value || 0);
          renderList('inbox');
          renderList('sent');
        });

        if ($('sidebarDaysFilter')) $('sidebarDaysFilter').addEventListener('change', (event) => {
          const value = Number(event.target.value || 0);
          if ($('daysFilter')) $('daysFilter').value = String(value);
          state.days = value;
          renderList('inbox');
          renderList('sent');
        });

        if ($('sidebarClearFilters')) $('sidebarClearFilters').addEventListener('click', () => {
          if ($('searchBox')) $('searchBox').value = '';
          if ($('sidebarSearchBox')) $('sidebarSearchBox').value = '';
          if ($('daysFilter')) $('daysFilter').value = '15';
          if ($('sidebarDaysFilter')) $('sidebarDaysFilter').value = '15';
          state.query = '';
          state.days = 15;
          renderList('inbox');
          renderList('sent');
        });

        $('fillSample').addEventListener('click', () => {
          $('fromEmail').value = state.activeMailboxEmail || defaultMailbox;
          $('toEmail').value = '<?php echo htmlspecialchars(MAIL_INFO, ENT_QUOTES, "UTF-8"); ?>';
          $('subject').value = 'Correo de prueba';
          setComposeMode('text');
          $('html').value = 'Hola,\n\nEste es un correo de prueba desde el panel.';
        });

        const listClick = (type) => async (event) => {
          const card = event.target.closest('.item');
          if (!card) return;
          const item = filteredItems(type)[Number(card.dataset.index)];
          if (!item) return;

          document.querySelectorAll('.email-item-card').forEach(el => el.classList.remove('active-card'));
          card.classList.add('active-card');

          showDetail(item, type === 'inbox' ? 'received' : 'sent');
        };

        $('inboxList').addEventListener('click', listClick('inbox'));
        $('sentList').addEventListener('click', listClick('sent'));

        $('replyBtn').addEventListener('click', () => {
          const item = state.currentDetail;
          if (!item) return;
          const target = state.currentDetailKind === 'sent' ? (item.to || '') : (item.from || '');
          $('fromEmail').value = state.activeMailboxEmail || defaultMailbox;
          $('toEmail').value = target;
          $('subject').value = subjectForReply(item.subject || '');
          setComposeMode('text');
          $('html').value = replyText(item);
          setActiveTab('compose');
        });

        $('toggleDetailView').addEventListener('click', () => {
          const item = state.currentDetail;
          if (!item) return;
          state.currentDetailView = state.currentDetailView === 'html' ? 'text' : 'html';
          $('toggleDetailView').textContent = state.currentDetailView === 'html' ? 'Vista normal' : 'Ver HTML';
          renderDetailBody(item, state.currentDetailView);
        });

        $('openComposeBtn').addEventListener('click', () => {
          const item = state.currentDetail;
          if (!item) return;
          const target = state.currentDetailKind === 'sent' ? (item.to || '') : (item.from || '');
          $('fromEmail').value = state.activeMailboxEmail || defaultMailbox;
          $('toEmail').value = target;
          $('subject').value = subjectForReply(item.subject || '');
          setComposeMode('text');
          $('html').value = replyText(item);
          setActiveTab('compose');
        });

        $('toggleComposeMode').addEventListener('click', () => {
          setComposeMode(state.composeMode === 'html' ? 'text' : 'html', true);
        });

        if ($('closeDetailBtn')) {
          $('closeDetailBtn').addEventListener('click', () => {
            showDetail(null);
            document.querySelectorAll('.email-item-card').forEach(el => el.classList.remove('active-card'));
          });
        }

        // Toggle Sidebar click handler
        if ($('toggleSidebarBtn')) {
          $('toggleSidebarBtn').addEventListener('click', () => {
            const container = document.querySelector('.main-container');
            if (container) {
              if (window.innerWidth > 1100) {
                container.classList.toggle('sidebar-collapsed');
              } else {
                container.classList.toggle('sidebar-mobile-open');
              }
            }
          });
        }

        // Close sidebar in mobile by overlay click
        if ($('sidebarOverlay')) {
          $('sidebarOverlay').addEventListener('click', () => {
            const container = document.querySelector('.main-container');
            if (container) {
              container.classList.remove('sidebar-mobile-open');
            }
          });
        }

        <?php if (correo_is_admin()): ?>
        $('reloadUsers').addEventListener('click', loadUsers);
        
        const mailboxActionsHandler = async (event) => {
          const mailbox = event.target.getAttribute('data-mailbox');
          const importEmail = event.target.getAttribute('data-import');
          if (mailbox) {
            state.importAfter = '';
            await loadMailbox(mailbox);
            $('usersStatus').textContent = 'Buzón activo: ' + mailbox;
            // Close mobile sidebar if clicked on mailbox ver/import
            const container = document.querySelector('.main-container');
            if (container) container.classList.remove('sidebar-mobile-open');
          }
          if (importEmail) {
            $('usersStatus').textContent = 'Importando historial...';
            const data = await api('importHistory', { email: importEmail, after: state.importAfter || '', limit: 5 });
            $('usersStatus').textContent = data.ok
              ? `Historial importado. Nuevos: ${data.imported || 0}, actualizados: ${data.updated || 0}.${data.has_more ? ' Quedan más, pulsa otra vez.' : ''}`
              : (data.error || 'No se pudo importar.');
            if (data.ok) {
              state.importAfter = data.next_after || '';
              await loadMailbox(importEmail);
            }
          }
        };

        $('usersList').addEventListener('click', mailboxActionsHandler);
        if ($('sidebarUsers')) {
          $('sidebarUsers').addEventListener('click', mailboxActionsHandler);
        }

        $('importHistory').addEventListener('click', async () => {
          const email = state.activeMailboxEmail || (($('newAssignedEmail') && $('newAssignedEmail').value.trim()) || $('newUserEmail').value.trim());
          if (!email) {
            $('usersStatus').textContent = 'Selecciona un buzón primero.';
            return;
          }
          $('usersStatus').textContent = 'Importando historial...';
          const data = await api('importHistory', { email, after: state.importAfter || '', limit: 5 });
          $('usersStatus').textContent = data.ok
            ? `Historial importado. Nuevos: ${data.imported || 0}, actualizados: ${data.updated || 0}.${data.has_more ? ' Quedan más, pulsa otra vez.' : ''}`
            : (data.error || 'No se pudo importar.');
          if (data.ok) {
            state.importAfter = data.next_after || '';
            await Promise.all([loadMailbox(email), loadUsers()]);
          }
        });
        <?php endif; ?>

        $('logoutBtn').addEventListener('click', async () => {
          await api('logout');
          location.reload();
        });

        // Dropdown Perfil
        const profileBtn = $('userProfileNode');
        const profileDropdown = $('profileDropdown');
        if (profileBtn && profileDropdown) {
          profileBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            profileDropdown.classList.toggle('show');
          });
          document.addEventListener('click', () => {
            profileDropdown.classList.remove('show');
          });
        }
        const dropdownLogoutBtn = $('dropdownLogoutBtn');
        if (dropdownLogoutBtn) {
          dropdownLogoutBtn.addEventListener('click', async (e) => {
            e.stopPropagation();
            await api('logout');
            location.reload();
          });
        }

        // Init
        setActiveTab('inbox');
        loadInbox().catch((e) => $('inboxStatus').textContent = e.message);
        loadSent().catch((e) => $('sentStatus').textContent = e.message);
        <?php if (correo_is_admin()): ?>loadUsers().catch((e) => $('usersStatus').textContent = e.message);<?php endif; ?>
        setActiveMailbox(state.activeMailboxEmail || defaultMailbox);
        setComposeMode('text');

        // Refresco silencioso de la base de datos local (0 peticiones a Resend API)
        async function silentRefreshLocal() {
          try {
            if (document.hidden) return;
            const email = state.activeMailboxEmail || defaultMailbox;
            if (!email) return;

            const received = await api('listMailbox', { kind: 'received', email });
            if (received.ok) {
              state.inbox = received.items || [];
              renderList('inbox');
            }
            const sent = await api('listMailbox', { kind: 'sent', email });
            if (sent.ok) {
              state.sent = sent.items || [];
              renderList('sent');
            }
          } catch (e) {
            console.error('Error en refresco silencioso local:', e);
          }
        }

        // Sincronización silenciosa desde Resend API (1 petición por minuto como fallback por si no hay webhooks)
        async function silentSyncResend() {
          try {
            if (document.hidden) return;
            const email = state.activeMailboxEmail || defaultMailbox;
            if (!email) return;

            const data = await api('importHistory', { email, limit: 5 });
            if (data.ok && (data.imported > 0 || data.updated > 0)) {
              await silentRefreshLocal();
            }
          } catch (e) {
            console.warn('Error en importación silenciosa de Resend:', e);
          }
        }

        // 1. Refresco local cada 15 segundos para recibir instantáneamente por Webhook (0 llamadas a Resend)
        setInterval(silentRefreshLocal, 15000);

        // 2. Sincronización automática de Resend cada 60 segundos por si no hay webhooks (1 llamada por minuto)
        setInterval(silentSyncResend, 60000);

        // 3. Sincronización inicial silenciosa de Resend al cargar la página
        <?php if (correo_is_admin()): ?>
        setTimeout(async () => {
          try {
            const email = state.activeMailboxEmail || defaultMailbox;
            if (email) {
              await api('importHistory', { email, limit: 5 });
              await silentRefreshLocal();
            }
          } catch (e) {
            console.warn('Error en sincronización inicial:', e);
          }
        }, 1500);
        <?php endif; ?>

        // Registrar Service Worker para soporte PWA (Mac & iPhone)
        if ('serviceWorker' in navigator) {
          window.addEventListener('load', () => {
            navigator.serviceWorker.register('sw.js')
              .then(reg => console.log('[PWA] Service Worker registrado:', reg.scope))
              .catch(err => console.warn('[PWA] Fallo al registrar Service Worker:', err));
          });
        }

        // Inicializar OneSignal si el App ID está configurado
        const oneSignalAppId = '<?php echo htmlspecialchars($oneSignalAppId, ENT_QUOTES, "UTF-8"); ?>';
        if (oneSignalAppId) {
          window.OneSignal = window.OneSignal || [];
          OneSignal.push(function() {
            OneSignal.init({
              appId: oneSignalAppId,
              allowLocalhostAsSecureOrigin: true,
              notifyButton: {
                enable: true,
              },
            });
          });
        }
      </script>
    <?php endif; ?>
  </div>
</body>
</html>
