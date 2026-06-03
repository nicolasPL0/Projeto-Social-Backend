<?php
$matricula = isset($_GET['matricula']) ? htmlspecialchars($_GET['matricula']) : '';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <title>Notificações — Projeto Social</title>
  <link rel="stylesheet" href="style.css" />

  <style>
    .container { max-width: 800px; }
    .filter-section-title { font-size: 13px; font-weight: 700; color: #555; text-transform: uppercase; letter-spacing: .5px; margin-bottom: 10px; }
    .class-header { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px; margin-bottom: 20px; }
    .action-group { display: flex; gap: 10px; flex-wrap: wrap; align-items: center; }
    .btn-action { display: inline-flex; align-items: center; gap: 8px; text-decoration: none; border: none; cursor: pointer; }
    .notif-list { display: flex; flex-direction: column; gap: 12px; padding: 8px 0; }
    .notif-card { display: grid; grid-template-columns: 52px 1fr auto; gap: 14px; align-items: start; padding: 16px 18px; border-radius: 8px; border: 1px solid #e8ecf0; background: #fff; box-shadow: 0 1px 4px rgba(0, 0, 0, .05); }
    .notif-icon { width: 52px; height: 52px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 22px; flex-shrink: 0; background: #f8fafb; color: #158a2f; border: 1px solid #e8ecf0; }
    .notif-icon.atraso { background: #fff7ec; color: #c76b00; border-color: #ffd8a8; }
    .notif-icon.ocorrencia { background: #fff1f1; color: #d93025; border-color: #ffc7c7; }
    .notif-icon.info { background: #eef5ff; color: #1463d6; border-color: #c9ddff; }
    .notif-body strong { display: block; font-size: 15px; margin-bottom: 4px; color: #222; }
    .notif-body span { display: block; color: #555; font-size: 13px; line-height: 1.6; margin-bottom: 8px; }
    .notif-meta { display: flex; flex-wrap: wrap; gap: 8px; font-size: 12px; color: #777; }
    .meta-chip { padding: 4px 8px; border-radius: 999px; background: #f6f8fa; border: 1px solid #e5e8ec; }
    .notif-time { font-size: 12px; color: #888; text-align: right; line-height: 1.5; min-width: 92px; }
    .notif-time button { margin-top: 26px; padding: 6px 10px; border: 1px solid #dcdcdc; border-radius: 999px; background: #fff; color: #c22a20; font-weight: 700; cursor: pointer; transition: background .2s ease, color .2s ease, border-color .2s ease; }
    .notif-time button:hover { background: #fef0f0; border-color: #f1c0c0; color: #a91914; }
    @media (max-width: 700px) { .notif-card { grid-template-columns: 1fr; } .notif-time { text-align: left; min-width: auto; } }
  </style>
</head>

<body>
  <header class="topbar">
    <div class="brand">
      <div class="logo"><span style="color:#f1ab08;">PROJETO </span>SOCIAL</div>
      <div class="subtitle">Gestão de Atrasos e Ocorrências — 2026</div>
    </div>
    <div class="angled-deco"></div>
  </header>

  <nav class="nav-row">
    <div class="container nav-inner">
      <div class="nav-links" id="navLinks">
        <a href="index.php"> INÍCIO</a>
        <a href="registro.php"> REGISTRO</a>
        <a href="cadastro.php"> CADASTRAR</a>
        <a href="historico.php"> HISTÓRICO</a>
      </div>
    </div>
  </nav>

  <div class="container page-content">
    <div class="page-title">Notificações</div>
    <div class="page-subtitle">Registros feitos em alunos, filtrados por curso, série, tipo e período.</div>

    <div class="stats-row">
      <div class="stat-card">
        <div class="stat-num" id="st-total">0</div>
        <div class="stat-label">Registros exibidos</div>
      </div>
      <div class="stat-card orange">
        <div class="stat-num" id="st-atraso">0</div>
        <div class="stat-label">Atrasos</div>
      </div>
      <div class="stat-card red">
        <div class="stat-num" id="st-ocorr">0</div>
        <div class="stat-label">Ocorrências</div>
      </div>
      <div class="stat-card blue">
        <div class="stat-num" id="st-info">0</div>
        <div class="stat-label">Outros</div>
      </div>
    </div>

    <div class="form-row">
      <div class="field">
        <label>Curso</label>
        <select id="curso" onchange="renderRegistros();">
          <option value="">Selecione</option>
          <option>Informática</option>
          <option>Finanças</option>
          <option>Enfermagem</option>
          <option>Estética</option>
          <option>Administração</option>
        </select>
      </div>
      <div class="field">
        <label>Série</label>
        <select id="turma" onchange="renderRegistros();">
          <option value="">Selecione</option>
          <option>1º Ano</option>
          <option>2º Ano</option>
          <option>3º Ano</option>
        </select>
      </div>
      <div class="field">
        <label>Período (Início)</label>
        <select id="periodo" onchange="renderRegistros();">
          <option value="">Selecione</option>
          <option>janeiro</option>
          <option>fevereiro</option>
          <option>março</option>
          <option>abril</option>
          <option>maio</option>
          <option>junho</option>
          <option>julho</option>
          <option>agosto</option>
          <option>setembro</option>
          <option>outubro</option>
          <option>novembro</option>
          <option>dezembro</option>
        </select>
      </div>
      <div class="field">
        <label>Período (Fim)</label>
        <select id="periodo-fim" onchange="renderRegistros();">
          <option value="">Selecione</option>
          <option>janeiro</option>
          <option>fevereiro</option>
          <option>março</option>
          <option>abril</option>
          <option>maio</option>
          <option>junho</option>
          <option>julho</option>
          <option>agosto</option>
          <option>setembro</option>
          <option>outubro</option>
          <option>novembro</option>
          <option>dezembro</option>
        </select>
      </div>
    </div>

    <div class="class-header">
      <div class="action-group" id="action-group-container">
        <button type="button" class="btn btn-primary btn-action" onclick="renderRegistros()">
          <i class="fa-solid fa-filter"></i>
          Filtrar registros
        </button>
        <button type="button" class="btn btn-primary btn-action" onclick="location.href='historico.php'">
          <i class="fa-solid fa-circle-check"></i>
          Voltar ao histórico
        </button>
      </div>
    </div>

    <div class="card">
      <div class="filter-section-title">Registros encontrados</div>
      <div id="lista-notifs" class="notif-list">
        <p style="text-align:center;color:#aaa;padding:40px;font-size:14px;">Carregando...</p>
      </div>
    </div>
  </div>

  <footer class="cookie">Direitos pertencentes a informática 3 2024-2026 | EEEP JOSÉ DE BARCELOS</footer>

  <script>
    const filterMatricula = "<?php echo $matricula; ?>";

    const MESES_MAP = {
      janeiro: 1, fevereiro: 2, março: 3, abril: 4, maio: 5, junho: 6,
      julho: 7, agosto: 8, setembro: 9, outubro: 10, novembro: 11, dezembro: 12
    };

    const ICONES = { atraso: '⏰', ocorrencia: '⚠️', info: 'ℹ️' };

    function formatarDataParaExibir(dataStr) {
      if (!dataStr) return '—';
      const p = dataStr.split('-');
      if (p.length === 3) {
        return `${p[2]}/${p[1]}/${p[0]}`;
      }
      return dataStr;
    }

    function renderStats(list) {
      document.getElementById('st-total').textContent = list.length;
      document.getElementById('st-atraso').textContent = list.filter(n => n.tipo === 'atraso').length;
      document.getElementById('st-ocorr').textContent = list.filter(n => n.tipo === 'ocorrencia').length;
      document.getElementById('st-info').textContent = list.filter(n => !n.tipo || n.tipo === 'info').length;
    }

    async function renderRegistros() {
      const curso = document.getElementById('curso').value;
      const turma = document.getElementById('turma').value;
      const periodoInicio = document.getElementById('periodo').value;
      const periodoFim = document.getElementById('periodo-fim').value;

      let url = `api_notificacoes.php?curso=${encodeURIComponent(curso)}&turma=${encodeURIComponent(turma)}`;
      
      if (periodoInicio && periodoFim) {
          url += `&mes_inicio=${MESES_MAP[periodoInicio.toLowerCase()]}&mes_fim=${MESES_MAP[periodoFim.toLowerCase()]}`;
      }
      if (filterMatricula) {
          url += `&matricula=${encodeURIComponent(filterMatricula)}`;
      }

      try {
          const res = await fetch(url);
          const registrosFiltrados = await res.json();
          const lista = document.getElementById('lista-notifs');

          if (!registrosFiltrados.length) {
            lista.innerHTML = '<p style="text-align:center;color:#aaa;padding:40px;font-size:14px;">Nenhum registro encontrado.</p>';
          } else {
            lista.innerHTML = registrosFiltrados.map(r => {
              const tipoIcon = ICONES[r.tipo] || '📢';
              const tipoClasse = r.tipo === 'atraso' ? 'atraso' : (r.tipo === 'ocorrencia' ? 'ocorrencia' : 'info');
              const dataExibicao = formatarDataParaExibir(r.data_registro);

              return `
              <div class="notif-card">
                <div class="notif-icon ${tipoClasse}">${tipoIcon}</div>
                <div class="notif-body">
                  <strong>${r.aluno_nome || r.aluno || 'Aluno'}</strong>
                  <span>
                    ${r.tipo_ocorrencia || 'Registro'} — ${r.observacoes || 'Sem observações.'}
                  </span>
                  <div class="notif-meta">
                    <span class="meta-chip">Curso: ${r.curso || '—'}</span>
                    <span class="meta-chip">Série: ${r.turma || '—'}</span>
                    <span class="meta-chip">Tipo: ${r.tipo_ocorrencia || '—'}</span>
                    ${r.motivo_saida ? `<span class="meta-chip">Motivo: ${r.motivo_saida}</span>` : ''}
                  </div>
                </div>
                <div class="notif-time" style="display: flex; flex-direction: column; justify-content: space-between; align-items: flex-end;">
                  <div>
                    ${dataExibicao}<br>
                    ${r.hora_registro || '—'}
                  </div>
                  <button onclick="deletarRegistroIndividual(${r.id})" title="Excluir este registro" style="margin-top:26px;">✕</button>
                </div>
              </div>
            `;
            }).join('');
          }
          renderStats(registrosFiltrados);
      } catch (e) {
          console.error(e);
      }
    }

    async function deletarRegistroIndividual(id) {
      if (confirm(`Deseja realmente apagar este registro?`)) {
          try {
              const res = await fetch('api_notificacoes.php', {
                  method: 'POST',
                  headers: { 'Content-Type': 'application/json' },
                  body: JSON.stringify({ action: 'delete', id })
              });
              const data = await res.json();
              if (data.success) {
                  renderRegistros();
              } else {
                  alert('Erro ao excluir');
              }
          } catch(e) {
              console.error(e);
          }
      }
    }

    async function clearAllRegistros() {
      if (!confirm('Deseja apagar todos os registros? Essa ação não pode ser desfeita.')) {
        return;
      }
      try {
          const res = await fetch('api_notificacoes.php', {
              method: 'POST',
              headers: { 'Content-Type': 'application/json' },
              body: JSON.stringify({ action: 'delete_all' })
          });
          const data = await res.json();
          if (data.success) {
              renderRegistros();
          } else {
              alert('Erro ao excluir todos os registros');
          }
      } catch(e) {
          console.error(e);
      }
    }

    window.addEventListener('load', () => {
      renderRegistros();

      const actionGroup = document.getElementById('action-group-container');
      if (actionGroup) {
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'btn btn-primary btn-action';
        btn.innerHTML = '<i class="fa-solid fa-trash"></i> Apagar tudo';
        btn.addEventListener('click', clearAllRegistros);
        actionGroup.appendChild(btn);
      }
    });
  </script>
</body>
</html>
