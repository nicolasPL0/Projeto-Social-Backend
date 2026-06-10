<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SABIÁ — EEEP José de Barcelos</title>
  <link rel="stylesheet" href="style.css" />
  <style>
    /* limita a largura do conteúdo nessa página */
    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 16px;
    }

    /* Estrutura de Grid para organizar o conteúdo */
    .main-grid {
      display: grid;
      grid-template-columns: 2fr 1fr;
      gap: 24px;
      margin-top: 24px;
      margin-bottom: 80px; /* espaço para o bottom-nav no mobile */
    }

    /* Cards gerais do sistema */
    .card {
      background: #fff;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
      padding: 20px;
      margin-bottom: 20px;
      border: 1px solid #eef2f5;
    }

    .card-title {
      font-size: 18px;
      font-weight: bold;
      color: #158a2f;
      margin-bottom: 16px;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    /* Caixa verde com as regras disciplinares da escola */
    .rule-box {
      background: #f0faf4;
      border-left: 4px solid #158a2f;
      padding: 16px;
      border-radius: 6px;
      font-size: 13px;
      line-height: 1.6;
      color: #333;
    }

    .rule-box strong {
      color: #158a2f;
    }

    /* Estilos para a tabela e dados dinâmicos do JS */
    .table-container {
      overflow-x: auto;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 14px;
      text-align: left;
    }

    th, td {
      padding: 12px;
      border-bottom: 1px solid #eee;
    }

    th {
      background-color: #f8f9fa;
      color: #555;
    }

    /* Estilos de Badges (Tolerância, Ocorrência, etc) */
    .badge {
      padding: 4px 8px;
      border-radius: 4px;
      font-size: 12px;
      font-weight: bold;
      display: inline-block;
    }
    .badge-green { background: #e6f4ea; color: #137333; }
    .badge-orange { background: #feefe3; color: #b06000; }
    .badge-red { background: #fce8e6; color: #c5221f; }
    .badge-gray { background: #f1f3f4; color: #5f6368; }

    /* Alertas de alunos */
    .alerta-item {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px;
      border-bottom: 1px solid #f5f5f5;
    }
    .alerta-turma {
      font-size: 12px;
      color: #777;
      margin-left: 6px;
    }
    .alerta-badges {
      display: flex;
      gap: 4px;
    }

    /* Layout dos blocos de resumo */
    .resumo-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 16px;
      margin-top: 10px;
    }
    .resumo-box {
      padding: 16px;
      border-radius: 8px;
      color: #fff;
      text-align: center;
    }
    .resumo-atrasos { background: #34a853; }
    .resumo-tolerancias { background: #fbbc05; }
    .resumo-ocorrencias { background: #ea4335; }
    .resumo-num { font-size: 32px; font-weight: bold; }
    .resumo-label { font-size: 13px; opacity: 0.9; }

    /* Info sobre o Sistema */
    .info-sistema-box {
      background: #f4f6fa;
      border-left: 4px solid #4285f4;
      padding: 14px;
      border-radius: 6px;
      font-size: 13.5px;
      color: #444;
      line-height: 1.5;
    }
    .info-sistema-box strong { color: #4285f4; }

    /* ajuste mobile: sidebar vai pra baixo do conteúdo principal */
    @media (max-width: 900px) {
      .main-grid {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>

<body>

  <header class="topbar">
    <div class="brand">
      <div class="logo"><span style="color:#f1ab08;">SABIÁ</span></div>
      <div class="subtitle">Gestão de Atrasos e Ocorrências — 2026</div>
    </div>
    <div class="angled-deco"></div>
  </header>

  <nav class="nav-row">
    <div class="container nav-inner">
      <div class="nav-header-row"></div>
      <div class="nav-links" id="navLinks">
        <a href="index.php" class="active"> INÍCIO</a>
        <a href="registro.php"> REGISTRO</a>
        <a href="cadastro.php"> CADASTRAR</a>
        <a href="historico.php"> HISTÓRICO</a>
      </div>
    </div>
  </nav>

  <div class="toast" id="toast"></div>

  <main class="container">
    <div class="main-grid">
      
      <div class="content-left">
        
        <div class="card">
          <div class="card-title">🦅 Sobre o Sistema SABIÁ</div>
          <div class="info-sistema-box">
            <p>O <strong>SABIÁ</strong> é a plataforma central de controle pedagógico e disciplinar da EEEP José de Barcelos. Aqui você pode <strong>cadastrar novos alunos</strong> e realizar o <strong>registro em tempo real</strong> de rotinas diárias, como: entradas em atraso, fardamento incorreto e saídas antecipadas.</p>
            <p style="margin-top: 8px;">O sistema monitora a assiduidade e aplica penalidades progressivas de forma automatizada para garantir a organização escolar.</p>
          </div>
        </div>

        <div class="card">
          <div class="card-title">📊 Resumo de Hoje</div>
          <div id="resumo-dia">
            <p class="text-loading">Carregando dados estatísticos...</p>
          </div>
        </div>

        <div class="card">
          <div class="card-title">⏱️ Últimas Movimentações</div>
          <div class="table-container">
            <table>
              <thead>
                <tr>
                  <th>Horário</th>
                  <th>Aluno/Matrícula</th>
                  <th>Turma</th>
                  <th>Tipo Evento</th>
                  <th>Classificação</th>
                </tr>
              </thead>
              <tbody id="tbody-ultimos">
                <tr>
                  <td colspan="5" class="table-empty-message">Buscando registros na API...</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

      </div> <aside class="sidebar">
        
        <div class="card">
          <div class="card-title">⚠️ Alunos em Alerta</div>
          <div id="alerta-home">
            <p class="text-loading">Verificando histórico de alertas...</p>
          </div>
        </div>

        <div class="card">
          <div class="card-title">⚖️ Regras e Diretrizes</div>
          <div class="rule-box">
            <p>Processamento automático dos horários de entrada da manhã:</p>
            <ul style="margin-left: 18px; margin-top: 8px; margin-bottom: 12px;">
              <li><strong>Até 07:20:</strong> Entrada Normal (Sem penalidades)</li>
              <li><strong>07:21 às 07:30:</strong> Tolerância</li>
              <li><strong>A partir de 07:31:</strong> Ocorrência Direta</li>
            </ul>
            
            <hr style="border:0; border-top:1px solid #d2e7d7; margin:12px 0;" />
            
            <p style="margin-bottom: 6px;"><strong>Regra de Conversão Acumulada:</strong></p>
            <p>A cada <strong>3 Advertências</strong> acumuladas → Gera-se automaticamente <strong>1 Ocorrência</strong>.</p>
            <p style="margin-top: 4px;">A cada <strong>3 Ocorrências</strong> acumuladas → Gera-se uma <strong>Notificação</strong> (contato com os responsáveis).</p>
            <p style="margin-top: 4px; color: #c5221f;">🚨 O acúmulo de <strong>3 Notificações</strong> resulta em <strong>Suspensão</strong> imediata.</p>
            
            <hr style="border:0; border-top:1px solid #d2e7d7; margin:12px 0;" />
            
            <p><strong>Fardamento Inadequado:</strong> Marcar esta opção gera uma Ocorrência Direta imediata no histórico do aluno, independente do horário de chegada.</p>
          </div>
        </div>
      </aside>

    </div></main>

  <nav class="bottom-nav">
    <a href="index.php" class="active">
      <span class="nav-icon">🏠</span>
      <span class="nav-text">Início</span>
    </a>
    <a href="registro.php">
      <span class="nav-icon">📝</span>
      <span class="nav-text">Registro</span>
    </a>
    <a href="cadastro.php">
      <span class="nav-icon">➕</span>
      <span class="nav-text">Cadastrar</span>
    </a>
    <a href="historico.php">
      <span class="nav-icon">⏳</span>
      <span class="nav-text">Histórico</span>
    </a>
  </nav>

  <script>
    // Abre/fecha o menu hambúrguer no mobile
    function toggleMenu() {
      document.getElementById('navLinks').classList.toggle('active');
    }

    // Busca os dados do dia na API e monta toda a página inicial
    async function renderHome() {
      try {
        const res = await fetch('api_index.php');
        const data = await res.json();

        // Filtra registros de atraso (tolerância ou ocorrência por horário)
        const atrasosHoje = data.hoje.filter(r =>
          r.tipo === 'Tolerância' || r.tipo === 'Ocorrência' || r.tipo_ocorrencia === 'Tolerância'
        );
        const tolerancias = atrasosHoje.filter(a => a.tipo === 'Tolerância');
        const ocorrencias = atrasosHoje.filter(a => a.tipo === 'Ocorrência');

        // Monta o resumo do dia
        const resumo = document.getElementById('resumo-dia');
        if (!atrasosHoje.length) {
          resumo.innerHTML = '<p class="text-loading">Nenhum atraso registrado hoje.</p>';
        } else {
          resumo.innerHTML = `
            <div class="resumo-container">
              <div class="resumo-box resumo-atrasos">
                <div class="resumo-num">${atrasosHoje.length}</div>
                <div class="resumo-label">registros de atraso</div>
              </div>
              <div class="resumo-box resumo-tolerancias">
                <div class="resumo-num">${tolerancias.length}</div>
                <div class="resumo-label">tolerâncias (7h21–7h30)</div>
              </div>
              <div class="resumo-box resumo-ocorrencias">
                <div class="resumo-num">${ocorrencias.length}</div>
                <div class="resumo-label">ocorrências (após 7h30)</div>
              </div>
            </div>`;
        }

        // Monta a lista de alunos em alerta (2+ ocorrências ou 2+ tolerâncias)
        const alertaEl = document.getElementById('alerta-home');
        const emAlerta = data.alertas;

        if (!emAlerta.length) {
          alertaEl.innerHTML = '<p class="text-loading">✅ Nenhum aluno em situação de alerta.</p>';
        } else {
          alertaEl.innerHTML = emAlerta.slice(0, 5).map(a => `
            <div class="alerta-item">
              <div>
                <strong>${a.nome}</strong>
                <span class="alerta-turma">${a.turma}</span>
              </div>
              <div class="alerta-badges">
                <span class="badge badge-orange">${a.tol} tol.</span>
                <span class="badge badge-red">${a.ocorr} ocorr.</span>
              </div>
            </div>`).join('');
        }

        // Monta a tabela dos últimos registros do dia (máx 8)
        const tbody = document.getElementById('tbody-ultimos');
        if (!data.hoje.length) {
          tbody.innerHTML = '<tr><td colspan="5" class="table-empty-message">Nenhum registro hoje.</td></tr>';
        } else {
          tbody.innerHTML = data.hoje.slice(0, 8).map(a => {
            let badgeClass = 'badge-green';
            let badgeLabel = a.tipo || 'Normal';

            if (a.tipo === 'Tolerância') badgeClass = 'badge-orange';
            else if (a.tipo === 'Ocorrência') badgeClass = 'badge-red';
            else if (a.tipo === 'Notificação') badgeClass = 'badge-red';
            else if (a.tipo === 'Suspensão') badgeClass = 'badge-red';
            else if (a.tipo === 'Saída Antecipada') badgeClass = 'badge-gray';

            return `<tr>
              <td><strong>${a.hora_registro || '—'}</strong></td>
              <td>${a.aluno || a.matricula}</td>
              <td>${a.turma}</td>
              <td><span class="badge badge-gray">${a.tipo_ocorrencia || 'Entrada'}</span></td>
              <td><span class="badge ${badgeClass}">${badgeLabel}</span></td>
            </tr>`;
          }).join('');
        }

      } catch (e) {
        console.error('Erro de conexão:', e);
        document.getElementById('resumo-dia').innerHTML = '<p class="text-loading">Erro de conexão.</p>';
      }
    }

    window.addEventListener('load', renderHome);
  </script>

</body>
</html>
