<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Projeto Social — EEEP José de Barcelos</title>
  <link rel="stylesheet" href="style.css" />
  <style>
    .container { max-width: 1000px; }
    .rule-box { background: #f0faf4; border-left: 4px solid #158a2f; padding: 16px; border-radius: 6px; font-size: 13px; line-height: 1.6; color: #333; }
    .rule-box strong { color: #158a2f; }
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

  <main class="container main-content-padding">
    <div class="main-grid">
      <div>
        <div class="card">
          <div class="card-title">📢 Resumo do Dia</div>
          <div id="resumo-dia">
            <p class="text-loading">Carregando informações...</p>
          </div>
        </div>

        <div class="card">
          <div class="card-title">⚠️ Alunos em Situação de Alerta</div>
          <div id="alerta-home">
            <p class="text-loading">Carregando informações...</p>
          </div>
        </div>

        <div class="card">
          <div class="card-title">🕐 Últimos Registros</div>
          <div class="table-wrap">
            <table>
              <thead>
                <tr>
                  <th>Hora</th>
                  <th>Aluno</th>
                  <th>Turma</th>
                  <th>Tipo</th>
                  <th>Situação</th>
                </tr>
              </thead>
              <tbody id="tbody-ultimos">
                <tr>
                  <td colspan="5" class="table-empty-message">Carregando...</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <aside class="sidebar">
        <div>
          <div class="card">
            <div class="card-title"> Diretrizes e Níveis de Tolerância</div>
            <div class="rule-box">
              <p>O sistema processa automaticamente os horários de entrada da manhã de acordo com os seguintes
                critérios:</p>
              <ul style="margin-left: 18px; margin-top: 8px; margin-bottom: 12px;">
                <li><strong>Até 07:20:</strong> Entrada Normal (Sem penalidades)</li>
                <li><strong>07:21 às 07:30:</strong> Tolerância</li>
                <li><strong>A partir de 07:31:</strong> Ocorrência Direta</li>
              </ul>
              <hr style="border:0; border-top:1px solid #d2e7d7; margin:12px 0;" />
              <p style="margin-bottom: 6px;"><strong> Regra de Conversão Acumulada:</strong></p>
              <p>A cada <strong>3 Advertências</strong> acumuladas
                Gera-se automaticamente <strong>1 Ocorrência</strong>.</p>
              <p>A cada <strong>3 Ocorrências</strong> acumuladas
                Gera-se uma <strong>Notificação</strong> para contato com o responsável.</p>
              <hr style="border:0; border-top:1px solid #d2e7d7; margin:12px 0;" />
              <p> <strong>Fardamento Inadequado:</strong> Marcar esta opção gera uma Ocorrência Direta imediata no
                histórico do aluno, independente do horário de chegada.</p>
            </div>
          </div>
        </div>
      </aside>
    </div>
  </main>

  <footer class="cookie">Direitos pertencentes a informática 3 2024-2026 | EEEP JOSÉ DE BARCELOS</footer>

  <script>
    async function renderHome() {
        try {
            const res = await fetch('api_index.php');
            const data = await res.json();

            // Filtrar registros de atraso (Tolerância e Ocorrência vindas de atraso)
            const atrasosHoje = data.hoje.filter(r =>
              r.tipo === 'Tolerância' || r.tipo === 'Ocorrência' || r.tipo_ocorrencia === 'Tolerância'
            );
            const tolerancias = atrasosHoje.filter(a => a.tipo === 'Tolerância');
            const ocorrencias = atrasosHoje.filter(a => a.tipo === 'Ocorrência');

            // Resumo do dia
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

            // Alerta
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

            // Últimos registros — usar o campo 'tipo' do banco diretamente
            const tbody = document.getElementById('tbody-ultimos');
            if (!data.hoje.length) {
                tbody.innerHTML = '<tr><td colspan="5" class="table-empty-message">Nenhum registro hoje.</td></tr>';
            } else {
                tbody.innerHTML = data.hoje.slice(0, 8).map(a => {
                    // Badge baseada no campo 'tipo' já classificado pelo servidor
                    let badgeClass = 'badge-green';
                    let badgeLabel = a.tipo || 'Normal';

                    if (a.tipo === 'Tolerância') {
                        badgeClass = 'badge-orange';
                    } else if (a.tipo === 'Ocorrência') {
                        badgeClass = 'badge-red';
                    } else if (a.tipo === 'Notificação') {
                        badgeClass = 'badge-red';
                    } else if (a.tipo === 'Suspensão') {
                        badgeClass = 'badge-red';
                    } else if (a.tipo === 'Saída Antecipada') {
                        badgeClass = 'badge-gray';
                    }

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
