<?php
require_once __DIR__ . '/lib.php';

correo_seed_admin();
correo_log_boot(array('page' => 'index', 'default_mailbox' => correo_default_mailbox(), 'mailboxes' => array_map(function ($m) { return $m['assigned_email'] ?? ($m['email'] ?? ''); }, correo_mailboxes())));

$user = correo_current_user();
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Panel de Correo</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root{--bg:#07111d;--panel:#0d1724;--panel-2:#111f31;--line:#20324b;--text:#e8eef7;--muted:#9ab0c9;--accent:#5dd6c0;--accent-2:#7aa7ff;--danger:#ff6b6b;--shadow:0 18px 48px rgba(0,0,0,.28)}
    *{box-sizing:border-box;margin:0;padding:0;font-family:'Inter',Segoe UI,Tahoma,Geneva,Verdana,sans-serif}
    body{margin:0;background-color:#070a13;color:#94a3b8;min-height:100vh;background-image:radial-gradient(circle at top left, rgba(59,130,246,.06) 0%, rgba(6,182,212,0) 70%);background-attachment:fixed}
    .wrap{max-width:1540px;margin:0 auto;padding:20px}
    .app-shell{display:grid;grid-template-columns:300px minmax(0,1fr);gap:18px;align-items:start}
    .hero,.card,.sidebar{background:rgba(13,23,36,.96);border:1px solid var(--line);border-radius:20px;box-shadow:var(--shadow)}
    .sidebar{position:sticky;top:20px;padding:16px;height:calc(100vh - 40px);overflow:auto}
    .main{min-width:0;display:flex;flex-direction:column;gap:18px}
    .hero{display:flex;justify-content:space-between;gap:16px;align-items:flex-end;padding:22px}
    .hero h1{margin:0;font-size:28px}
    .hero p{margin:8px 0 0;color:var(--muted);max-width:760px;line-height:1.45}
    .badge,.pill{display:inline-flex;align-items:center;gap:8px;padding:10px 14px;border-radius:999px;background:rgba(93,214,192,.12);color:var(--accent);font-size:13px;font-weight:700;border:1px solid rgba(93,214,192,.25)}
    .pill{background:#16263a;color:#cfe0ff;border-color:var(--line)}
    .grid{display:grid;grid-template-columns:1.1fr .9fr;gap:18px}
    .card{overflow:hidden}
    .card h2{margin:0;padding:16px 18px;border-bottom:1px solid var(--line);font-size:16px;background:rgba(255,255,255,.02)}
    .card .body{padding:18px}
    .tabs{display:flex;gap:8px;flex-wrap:wrap;margin-bottom:16px}
    .tab,.btn{border:0;border-radius:12px;padding:12px 16px;font-weight:800;cursor:pointer}
    .tab{background:var(--panel-2);color:var(--text);border:1px solid var(--line)}
    .tab.active{background:linear-gradient(135deg,rgba(122,167,255,.25),rgba(93,214,192,.18));border-color:#3a5f94}
    .btn{background:linear-gradient(135deg,var(--accent-2),var(--accent));color:#05101a}
    .btn.secondary{background:#16263a;color:var(--text);border:1px solid var(--line)}
    .btn.danger{background:linear-gradient(135deg,#ff7e7e,var(--danger));color:#160708}
    .toolbar{display:flex;gap:10px;flex-wrap:wrap;margin-bottom:16px}
    .input,.textarea{width:100%;border:1px solid var(--line);background:#09111b;color:var(--text);border-radius:12px;padding:12px 14px;font-size:14px;outline:none}
    .textarea{min-height:152px;resize:vertical}
    .row{display:grid;grid-template-columns:1fr 1fr;gap:12px}
    .list{display:flex;flex-direction:column;gap:10px}
    .item{border:1px solid var(--line);border-radius:16px;background:#09111b;padding:14px;cursor:pointer}
    .item:hover{border-color:#39577f}
    .meta{display:flex;justify-content:space-between;gap:12px;color:var(--muted);font-size:12px;margin-bottom:8px}
    .subject{font-size:15px;font-weight:800;margin:0 0 8px}
    .snippet{color:#c7d3e2;font-size:13px;line-height:1.45;white-space:pre-wrap}
    .detail{border:1px solid var(--line);border-radius:16px;background:#09111b;padding:16px;min-height:240px}
    .detail h3{margin:0 0 10px;font-size:18px}
    .detail .small,.status{color:var(--muted);font-size:13px}
    .preview{margin-top:14px;overflow:auto;border-top:1px solid var(--line);padding-top:14px}
    .preview iframe{width:100%;min-height:420px;border:0;border-radius:12px;background:#fff}
    .wrap.login-page{max-width:none;min-height:100vh;display:flex;align-items:center;justify-content:center;padding:20px;overflow:hidden}
    .login-card{background-color:#0b0f19;border:1px solid #1e293b;border-radius:16px;width:100%;max-width:500px;padding:40px;box-shadow:0 20px 25px -5px rgba(0,0,0,.5),0 10px 10px -5px rgba(0,0,0,.4);position:relative}
    .login-title{color:#fff;font-size:21px;font-weight:600;margin:0 0 30px;border-bottom:1px solid #1e293b;padding-bottom:18px;letter-spacing:-.5px}
    .login-form{display:flex;flex-direction:column}
    .login-group{margin-bottom:24px;display:flex;flex-direction:column;gap:8px}
    .login-label{color:#94a3b8;font-size:13px;font-weight:500;letter-spacing:.2px}
    .login-input-wrap{position:relative;display:flex;align-items:center}
    .login-icon{position:absolute;left:16px;color:#64748b;font-size:15px;pointer-events:none;display:inline-flex;align-items:center;justify-content:center;width:18px;height:18px}
    .login-input{width:100%;background-color:#e2e8f0;color:#0f172a;border:2px solid transparent;padding:14px 16px 14px 46px;border-radius:12px;font-size:14px;font-weight:500;outline:none;transition:all .2s ease}
    .login-input::placeholder{color:#94a3b8;font-weight:400;opacity:.8}
    .login-input:focus{background-color:#fff;border-color:#3b82f6;box-shadow:0 0 0 4px rgba(59,130,246,.15)}
    .login-input:focus + .login-icon{color:#3b82f6}
    .login-submit{background:linear-gradient(135deg,#4ade80 0%,#3b82f6 50%,#06b6d4 100%);background-size:200% auto;color:#070a13;border:none;padding:12px 32px;border-radius:10px;font-weight:700;font-size:14px;letter-spacing:.3px;cursor:pointer;display:inline-block;margin-top:8px;margin-bottom:25px;transition:all .3s cubic-bezier(.4,0,.2,1);box-shadow:0 4px 12px rgba(6,182,212,.25);width:max-content}
    .login-submit:hover{background-position:right center;box-shadow:0 6px 16px rgba(6,182,212,.45);transform:translateY(-1px)}
    .login-submit:active{transform:translateY(0)}
    .login-note{font-size:11px;color:#475569;line-height:1.6;border-top:1px solid #1e293b;padding-top:18px;display:flex;align-items:flex-start;gap:8px}
    .login-note svg{margin-top:2px;flex:0 0 auto;color:#64748b}
    .login-note code{font-family:'Courier New',Courier,monospace;background-color:#111827;color:#94a3b8;padding:2px 6px;border-radius:4px;font-size:11px;font-weight:600;border:1px solid #1e293b}
    .login-error{margin-top:8px;color:#fca5a5;font-size:12px;display:none}
    .small{color:var(--muted);font-size:13px;margin-bottom:8px;display:block}
    .table{width:100%;border-collapse:collapse}
    .table th,.table td{padding:10px 8px;border-bottom:1px solid #22354e;text-align:left;font-size:13px;vertical-align:top}
    .actions{display:flex;gap:8px;flex-wrap:wrap}
    .mailbox{border:1px solid var(--line);border-radius:16px;background:#09111b;padding:14px}
    .mailbox.active{border-color:#5dd6c0;box-shadow:0 0 0 1px rgba(93,214,192,.18) inset}
    .sidebar .section{padding:14px 0;border-top:1px solid rgba(32,50,75,.8);margin-top:14px}
    .sidebar .section:first-of-type{border-top:0;margin-top:0;padding-top:0}
    .sidebar .brand{display:flex;justify-content:space-between;gap:12px;align-items:flex-start}
    .sidebar .brand h2{margin:0;font-size:22px}
    .sidebar .brand .small{margin:6px 0 0}
    .nav{display:grid;gap:8px}
    .nav .tab{width:100%;text-align:left}
    .sidebar-list{display:flex;flex-direction:column;gap:10px}
    .sidebar-card{border:1px solid var(--line);border-radius:16px;background:#09111b;padding:12px}
    .sidebar-card.active{border-color:#5dd6c0}
    .sidebar-card .title{font-weight:800;margin:0 0 4px}
    .sidebar-card .meta{display:flex;justify-content:space-between;gap:10px}
    .sidebar .quick-actions{display:grid;grid-template-columns:1fr 1fr;gap:8px}
    .sidebar .quick-actions .btn{padding:10px 12px}
    .sidebar .search-inline{display:grid;gap:10px}
    #tab-users .row{display:none}
    #tab-users #saveUser{display:none}
    @media (max-width:1180px){.app-shell{grid-template-columns:1fr}.sidebar{position:static;height:auto}.grid{grid-template-columns:1fr}}
    @media (max-width:980px){.hero{flex-direction:column;align-items:flex-start}.row{grid-template-columns:1fr}}
  </style>
</head>
<body>
  <div class="wrap<?php echo !$user ? ' login-page' : ''; ?>">
    <?php if (!$user): ?>
      <div class="login-card">
        <h2 class="login-title">Ingreso al panel</h2>
        <form class="login-form" autocomplete="off">
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
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
      <div class="app-shell">
        <aside class="sidebar">
          <div class="brand">
            <div>
              <div class="badge">Panel de correo</div>
              <h2>Correo</h2>
              <div class="small">Buz&oacute;n activo</div>
              <div class="pill" id="activeMailboxLabel"><?php echo htmlspecialchars(correo_default_mailbox(), ENT_QUOTES, 'UTF-8'); ?></div>
            </div>
            <span class="pill"><?php echo htmlspecialchars($user['role'], ENT_QUOTES, 'UTF-8'); ?></span>
          </div>

          <div class="section">
            <div class="small">Navegaci&oacute;n</div>
            <div class="nav">
              <button class="tab active" data-tab="inbox">Recibidos</button>
              <button class="tab" data-tab="sent">Enviados</button>
              <button class="tab" data-tab="compose">Nuevo</button>
              <?php if (correo_is_admin()): ?><button class="tab" data-tab="users">Buzones</button><?php endif; ?>
            </div>
          </div>

          <div class="section">
            <div class="small">Buscar</div>
            <div class="search-inline">
              <input class="input" id="sidebarSearchBox" placeholder="Remitente, destinatario o asunto">
              <select class="input" id="sidebarDaysFilter">
                <option value="15">Ultimos 15 dias</option>
                <option value="7">Ultimos 7 dias</option>
                <option value="30">Ultimos 30 dias</option>
                <option value="90">Ultimos 90 dias</option>
                <option value="0">Todo</option>
              </select>
              <button class="btn secondary" id="sidebarClearFilters">Limpiar filtros</button>
            </div>
          </div>

          <?php if (correo_is_admin()): ?>
          <div class="section">
            <div class="small">Buzones</div>
            <div class="sidebar-list" id="sidebarUsers">
              <div class="sidebar-card"><div class="title">Cargando...</div><div class="snippet">Espera un momento.</div></div>
            </div>
          </div>
          <?php endif; ?>

          <div class="section">
            <div class="small">Acciones</div>
            <div class="quick-actions">
              <button class="btn secondary" id="sidebarReloadInbox">Recibidos</button>
              <button class="btn secondary" id="sidebarReloadSent">Enviados</button>
              <button class="btn secondary" id="sidebarImportHistory">Importar</button>
              <button class="btn secondary" id="sidebarLogout">Salir</button>
            </div>
          </div>
        </aside>
        <main class="main">
      <div class="hero">
        <div>
          <div class="badge">Panel de correo</div>
          <h1>Correo</h1>
          <div class="status">Buzón activo: <strong id="activeMailboxLabel"><?php echo htmlspecialchars(correo_default_mailbox(), ENT_QUOTES, 'UTF-8'); ?></strong></div>
          <p>Panel simple para enviar, recibir y revisar historial por buzón. <?php echo htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8'); ?> | <?php echo htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8'); ?></p>
        </div>
        <div class="actions">
          <span class="pill"><?php echo htmlspecialchars($user['role'], ENT_QUOTES, 'UTF-8'); ?></span>
          <button class="btn secondary" id="logoutBtn">Salir</button>
        </div>
      </div>

      <div class="grid">
        <div class="card">
          <h2>Correo</h2>
          <div class="body">
            <div class="tabs">
              <button class="tab active" data-tab="inbox">Recibidos</button>
              <button class="tab" data-tab="sent">Enviados</button>
              <button class="tab" data-tab="compose">Nuevo</button>
              <?php if (correo_is_admin()): ?><button class="tab" data-tab="users">Buzones</button><?php endif; ?>
            </div>
            <div class="toolbar">
              <input class="input" id="searchBox" placeholder="Buscar por remitente, destinatario o asunto" style="flex:1;min-width:220px">
              <select class="input" id="daysFilter" style="max-width:220px">
                <option value="15">Ultimos 15 dias</option>
                <option value="7">Ultimos 7 dias</option>
                <option value="30">Ultimos 30 dias</option>
                <option value="90">Ultimos 90 dias</option>
                <option value="0">Todo</option>
              </select>
              <button class="btn secondary" id="clearFilters">Limpiar</button>
            </div>

            <div id="tab-inbox">
              <div class="toolbar"><button class="btn secondary" id="reloadInbox">Actualizar recibidos</button></div>
              <div class="list" id="inboxList"></div>
              <div class="status" id="inboxStatus"></div>
            </div>

            <div id="tab-sent" style="display:none">
              <div class="toolbar"><button class="btn secondary" id="reloadSent">Actualizar enviados</button></div>
              <div class="list" id="sentList"></div>
              <div class="status" id="sentStatus"></div>
            </div>

            <div id="tab-compose" style="display:none">
              <div class="row">
                <div><label class="small">Desde</label><input class="input" id="fromEmail" placeholder="no-reply@iqmaximo.com"></div>
                <div><label class="small">Para</label><input class="input" id="toEmail" placeholder="destino@dominio.com"></div>
              </div>
              <div style="height:10px"></div>
              <label class="small">Asunto</label>
              <input class="input" id="subject" placeholder="Asunto del correo">
              <div style="height:10px"></div>
              <div class="toolbar" style="margin-bottom:8px">
                <label class="small" id="composeLabel" style="margin:0">Mensaje</label>
                <button class="btn secondary" id="toggleComposeMode" type="button">Ver HTML</button>
              </div>
              <textarea class="textarea" id="html" placeholder="<p>Hola...</p>"></textarea>
              <div style="height:10px"></div>
              <div class="toolbar">
                <button class="btn" id="sendEmail">Enviar correo</button>
                <button class="btn secondary" id="fillSample">Cargar ejemplo</button>
              </div>
              <div class="status" id="sendStatus"></div>
            </div>

            <?php if (correo_is_admin()): ?>
            <div id="tab-users" style="display:none">
              <div class="toolbar">
                <button class="btn secondary" id="reloadUsers">Actualizar buzones</button>
              </div>
              <div class="row">
                <div>
                  <label class="small">Usuario</label>
                  <input class="input" id="newUsername" placeholder="usuario.panel">
                </div>
                <div>
                  <label class="small">Email asignado</label>
                  <input class="input" id="newUserEmail" placeholder="correo@iqmaximo.com">
                </div>
              </div>
              <div style="height:10px"></div>
              <div class="row">
                <div>
                  <label class="small">Correo para historial</label>
                  <input class="input" id="newAssignedEmail" placeholder="fparedes@iqmaximo.com">
                </div>
                <div></div>
              </div>
              <div style="height:10px"></div>
              <div class="row">
                <div>
                  <label class="small">Contraseña</label>
                  <input class="input" id="newUserPass" type="password" placeholder="********">
                </div>
                <div>
                  <label class="small">Rol</label>
                  <select class="input" id="newUserRole">
                    <option value="user">user</option>
                    <option value="admin">admin</option>
                  </select>
                </div>
              </div>
              <div style="height:10px"></div>
              <div class="toolbar">
                <button class="btn" id="saveUser">Guardar usuario</button>
                <button class="btn secondary" id="importHistory">Importar historial</button>
              </div>
              <div class="status" id="usersStatus"></div>
              <div class="list" id="usersList" style="margin-top:12px"></div>
            </div>
            <?php endif; ?>
          </div>
        </div>

        <div class="card">
          <h2>Detalle</h2>
          <div class="body">
            <div class="detail">
              <h3 id="detailTitle">Selecciona un correo</h3>
              <div class="small" id="detailMeta">Aquí verás el contenido completo del mensaje.</div>
              <div class="toolbar" style="margin-top:12px">
                <button class="btn" id="replyBtn" disabled>Responder</button>
                <button class="btn secondary" id="openComposeBtn" disabled>Editar respuesta</button>
                <button class="btn secondary" id="toggleDetailView" disabled>Ver HTML</button>
              </div>
              <div class="preview" id="detailBody"></div>
            </div>
          </div>
        </div>
      </div>
        </main>
      </div>

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
        const setActiveMailbox = (email) => {
          state.activeMailboxEmail = String(email || '').trim() || defaultMailbox;
          $('activeMailboxLabel').textContent = state.activeMailboxEmail;
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
        const replyHtml = (item) => {
          const from = esc(item.from || '');
          const to = esc(item.to || '');
          const subject = esc(item.subject || '');
          const body = item.html || item.text || '<p>Sin contenido original.</p>';
          return `
            <div style="font-family:Arial,sans-serif;font-size:14px;line-height:1.6;color:#111">
              <p>Hola,</p>
              <p></p>
              <p>---</p>
              <p><strong>Mensaje original</strong></p>
              <p><strong>De:</strong> ${from}</p>
              <p><strong>Para:</strong> ${to}</p>
              <p><strong>Asunto:</strong> ${subject}</p>
              <div style="border-left:3px solid #ccc;padding-left:12px;margin-top:12px">${body}</div>
            </div>
          `;
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
          $('detailBody').innerHTML = `<div class="snippet" style="white-space:pre-wrap;line-height:1.6">${esc(text || 'Sin contenido.')}</div>`;
        };
        async function api(action, payload = {}) {
          const response = await fetch('./api.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ action, ...payload }),
          });
          return response.json();
        }
        function setActiveTab(name) {
          document.querySelectorAll('.tab').forEach((btn) => btn.classList.toggle('active', btn.dataset.tab === name));
          ['inbox','sent','compose','users'].forEach((tab) => { const el = $('tab-' + tab); if (el) el.style.display = tab === name ? 'block' : 'none'; });
        }
        function filteredItems(type) {
          const query = String(state.query || '').trim().toLowerCase();
          const days = Number(state.days || 0);
          const cutoff = new Date();
          if (days > 0) {
            cutoff.setDate(cutoff.getDate() - days);
          }
          return (state[type] || []).filter((item) => {
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
          if (!list.length) { target.innerHTML = '<div class="item"><div class="snippet">Sin datos.</div></div>'; status.textContent = 'Sin datos.'; return; }
          target.innerHTML = list.map((item, index) => `
            <div class="item" data-index="${index}">
              <div class="meta"><span><strong>De:</strong> ${esc(item.from || '-')}</span><span>${esc(item.created_at || '')}</span></div>
              <div class="meta"><span><strong>Para:</strong> ${esc(item.to || '-')}</span><span class="pill">${esc(item.status || type)}</span></div>
              <div class="subject">${esc(item.subject || '(sin asunto)')}</div>
              <div class="snippet">${esc((item.preview || item.text || item.html || '').slice(0, 220))}</div>
            </div>
          `).join('');
          status.textContent = `${list.length} correo(s) cargado(s).`;
        }
        function showDetail(item, kind = 'received') {
          state.currentDetail = item;
          state.currentDetailKind = kind;
          state.currentDetailView = 'text';
          $('detailTitle').textContent = item.subject || '(sin asunto)';
          $('detailMeta').textContent = `${item.from || '-'} -> ${item.to || '-'}`.trim();
          renderDetailBody(item, state.currentDetailView);
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
                <div class="toolbar" style="margin-top:10px">
                  <button class="btn secondary" data-mailbox="${esc(mailbox)}">Ver historial</button>
                  <button class="btn secondary" data-import="${esc(mailbox)}">Importar historial</button>
                </div>
              </div>
            `;
          }).join('');
          if ($('sidebarUsers')) {
            $('sidebarUsers').innerHTML = state.users.map((user) => {
              const mailbox = user.assigned_email || user.email || '';
              const active = String(mailbox).toLowerCase() === String(state.activeMailboxEmail || '').toLowerCase();
              return `
                <div class="sidebar-card ${active ? 'active' : ''}">
                  <div class="meta"><span><strong>${esc(user.username || mailbox)}</strong></span><span>${user.active ? 'activo' : 'inactivo'}</span></div>
                  <div class="snippet">${esc(mailbox || user.email || '')}</div>
                  <div class="toolbar" style="margin-top:10px">
                    <button class="btn secondary" data-mailbox="${esc(mailbox)}">Ver</button>
                    <button class="btn secondary" data-import="${esc(mailbox)}">Importar</button>
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
        document.querySelectorAll('.tab').forEach((btn) => btn.addEventListener('click', () => setActiveTab(btn.dataset.tab)));
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
        $('clearFilters').addEventListener('click', () => {
          $('searchBox').value = '';
          $('daysFilter').value = '15';
          state.query = '';
          state.days = 15;
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
        <?php if (correo_is_admin()): ?>
        $('reloadUsers').addEventListener('click', loadUsers);
        $('usersList').addEventListener('click', async (event) => {
          const mailbox = event.target.getAttribute('data-mailbox');
          const importEmail = event.target.getAttribute('data-import');
          if (mailbox) {
            state.importAfter = '';
            await loadMailbox(mailbox);
            $('usersStatus').textContent = 'Buzón activo: ' + mailbox;
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
        });
        if ($('sidebarUsers')) {
          $('sidebarUsers').addEventListener('click', async (event) => {
            const mailbox = event.target.getAttribute('data-mailbox');
            const importEmail = event.target.getAttribute('data-import');
            if (mailbox) {
              state.importAfter = '';
              await loadMailbox(mailbox);
              if ($('usersStatus')) $('usersStatus').textContent = 'Buzón activo: ' + mailbox;
            }
            if (importEmail) {
              if ($('usersStatus')) $('usersStatus').textContent = 'Importando historial...';
              const data = await api('importHistory', { email: importEmail, after: state.importAfter || '', limit: 5 });
              if ($('usersStatus')) {
                $('usersStatus').textContent = data.ok
                  ? `Historial importado. Nuevos: ${data.imported || 0}, actualizados: ${data.updated || 0}.${data.has_more ? ' Quedan más, pulsa otra vez.' : ''}`
                  : (data.error || 'No se pudo importar.');
              }
              if (data.ok) {
                state.importAfter = data.next_after || '';
                await loadMailbox(importEmail);
              }
            }
          });
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
        setActiveTab('inbox');
        loadInbox().catch((e) => $('inboxStatus').textContent = e.message);
        loadSent().catch((e) => $('sentStatus').textContent = e.message);
        <?php if (correo_is_admin()): ?>loadUsers().catch((e) => $('usersStatus').textContent = e.message);<?php endif; ?>
        setActiveMailbox(state.activeMailboxEmail || defaultMailbox);
        setComposeMode('text');
      </script>
    <?php endif; ?>
  </div>
</body>
</html>
