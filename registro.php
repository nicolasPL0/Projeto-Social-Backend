<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>CHECKPEOPLE — Registrar Ocorrência</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="style.css">
  <style>
    .container { max-width: 1100px; }
    .registro-layout { display: grid; grid-template-columns: 1fr 300px; gap: 24px; align-items: start; }
    .tipo-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; margin-bottom: 22px; }
    .box-tipo { display: flex; flex-direction: column; align-items: center; gap: 6px; padding: 14px 10px; border: 2px solid #dde2e8; border-radius: 6px; cursor: pointer; font-size: 12px; font-weight: 700; color: #666; text-align: center; transition: all .15s; background: #fff; user-select: none; }
    .box-tipo i { font-size: 20px; color: #aaa; transition: color .15s; }
    .box-tipo:hover { border-color: #158a2f; color: #158a2f; }
    .box-tipo:hover i { color: #158a2f; }
    .box-tipo.active { border-color: #158a2f; background: #f0faf4; color: #158a2f; }
    .box-tipo.active i { color: #158a2f; }
    .form-section-label { font-size: 11px; font-weight: 700; color: #888; text-transform: uppercase; letter-spacing: .6px; margin-bottom: 10px; }
    .form-actions { display: flex; gap: 10px; margin-top: 6px; flex-wrap: wrap; }
    .toast { position: fixed; top: 20px; right: 20px; display: none; min-width: 260px; max-width: 360px; padding: 14px 18px; border-radius: 8px; color: #fff; font-weight: 700; z-index: 9999; box-shadow: 0 10px 25px rgba(0,0,0,0.18); animation: fadeIn 0.25s ease; }
    .toast.success { background: #28a745; }
    .toast.error { background: #dc3545; }
    .info-box { background: #f0faf4; border-left: 4px solid #158a2f; padding: 18px; border-radius: 6px; font-size: 13px; line-height: 1.65; color: #333; }
    .info-box strong { color: #158a2f; }
    .info-box .info-title { font-size: 14px; font-weight: 700; color: #158a2f; margin-bottom: 10px; display: flex; align-items: center; gap: 6px; }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
    .form-row.full { grid-template-columns: 1fr; }
    .field label { display: block; margin-bottom: 6px; font-size: 13px; font-weight: 700; color: #555; }
    .field input, .field select, .field textarea { width: 100%; padding: 12px 14px; border: 1px solid #d7dde4; border-radius: 6px; background: #fff; outline: none; font-size: 14px; transition: border-color .15s, box-shadow .15s; }
    .field input:focus, .field select:focus, .field textarea:focus { border-color: #158a2f; box-shadow: 0 0 0 3px rgba(21, 138, 47, 0.08); }
    .responsavel-box { display: none; margin-top: 10px; padding: 14px 16px; background: #f8fafb; border: 1px solid #dfe7df; border-left: 4px solid #158a2f; border-radius: 6px; font-size: 13px; line-height: 1.7; color: #333; }
    .responsavel-box strong { color: #158a2f; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
    @media (max-width: 800px) { .registro-layout { grid-template-columns: 1fr; } .tipo-grid { grid-template-columns: 1fr 1fr 1fr; } }
    @media (max-width: 500px) { .tipo-grid { grid-template-columns: 1fr; } .form-row { grid-template-columns: 1fr; } }
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
        <a href="index.php">INÍCIO</a>
        <a href="registro.php" class="active">REGISTRO</a>
        <a href="cadastro.php">CADASTRAR</a>
        <a href="historico.php">HISTÓRICO</a>
      </div>
    </div>
  </nav>

  <div class="toast" id="toast"></div>

  <main class="container page-content">
    <div class="page-title">Registrar Ocorrência</div>
    <div class="page-subtitle">Selecione o tipo de ocorrência e preencha os dados do estudante correspondente.</div>
    <div class="registro-layout">
      <div class="card">
        <div class="form-section-label">Tipo de Ocorrência</div>
        <div class="tipo-grid">
          <div class="box-tipo active" onclick="selectTipo(this,'Tolerância')">
            <i class="fa-solid fa-clock"></i>
            <span>Tolerância / Atraso</span>
          </div>
          <div class="box-tipo" onclick="selectTipo(this,'Notificação')">
            <i class="fa-solid fa-bell"></i>
            <span>Notificação</span>
          </div>
          <div class="box-tipo" onclick="selectTipo(this,'Fardamento')">
            <i class="fa-solid fa-shirt"></i>
            <span>Fardamento</span>
          </div>
          <div class="box-tipo" onclick="selectTipo(this,'Saída Antecipada')">
            <i class="fa-solid fa-right-from-bracket"></i>
            <span>Saída Antecipada</span>
          </div>
        </div>
        <input type="hidden" id="tipoOcorrenciaInput" value="Tolerância">

        <div class="form-section-label" style="margin-top:4px;">Dados do Estudante</div>
        <form id="formOcorrencia">
          <div class="form-row" style="margin-bottom:14px;">
            <div class="field">
              <label>Curso</label>
              <select name="curso" id="curso" required>
                <option value="">Selecione o curso...</option>
                <option>Informática</option>
                <option>Finanças</option>
                <option>Enfermagem</option>
                <option>Estética</option>
                <option>Administração</option>
              </select>
            </div>
            <div class="field">
              <label>Série</label>
              <select name="serie" id="serie" required>
                <option value="">Selecione a série...</option>
                <option>1º Ano</option>
                <option>2º Ano</option>
                <option>3º Ano</option>
              </select>
            </div>
          </div>
          <div class="form-row full" style="margin-bottom:14px;">
            <div class="field">
              <label>Aluno</label>
              <select name="aluno" id="aluno" required>
                <option value="">Selecione o aluno...</option>
              </select>
              <div id="responsavelBox" class="responsavel-box"></div>
            </div>
          </div>

          <div id="saidaAntecipadaFields" style="display:none;">
            <div class="form-row full" style="margin-bottom:8px;">
              <div class="field">
                <label>Motivo da Saída Antecipada</label>
                <select name="motivo_saida" id="motivoSaida">
                  <option value="">Selecione o motivo...</option>
                  <option>Consulta médica</option>
                  <option>Problema familiar</option>
                  <option>Transporte</option>
                  <option>Atividade externa</option>
                  <option>Outros</option>
                </select>
              </div>
            </div>
            <div class="form-row full" id="outroMotivoBox" style="display:none; margin-bottom:14px;">
              <div class="field">
                <label>Qual o motivo?</label>
                <textarea name="outro_motivo" id="outroMotivo" rows="3" placeholder="Descreva o motivo..."></textarea>
              </div>
            </div>
            <div class="form-row" style="margin-bottom:14px;">
              <div class="field"><label>Data da Saída</label><input type="date" name="data_saida" id="dataSaida"></div>
              <div class="field"><label>Horário da Saída</label><input type="time" name="horario_saida" id="horarioSaida"></div>
            </div>
          </div>

          <div class="form-row" style="margin-bottom:14px;" id="ocorrenciaFields">
            <div class="field"><label>Data</label><input type="date" name="data" id="dataOcorrencia"></div>
            <div class="field"><label>Horário</label><input type="time" name="horario" id="horarioChegada"></div>
          </div>
          <div class="form-row full" style="margin-bottom:18px;">
            <div class="field">
              <label>Observações</label>
              <textarea name="observacoes" id="observacoes" placeholder="Observações adicionais ou justificativas..." rows="3"></textarea>
            </div>
          </div>
          <div class="form-actions">
            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-circle-check"></i> Finalizar Registro</button>
            <button type="reset" class="btn btn-ghost"><i class="fa-solid fa-trash-can"></i> Limpar</button>
          </div>
        </form>
      </div>

      <aside>
        <div class="info-box">
          <div class="info-title"><i class="fa-solid fa-circle-info"></i> Instruções</div>
          <p>Utilize este formulário para registrar atrasos, notificações, irregularidades de fardamento e saídas antecipadas.</p><br>
          <p><strong>Atenção:</strong> Os dados salvos aqui serão usados pela página de notificações e histórico.</p><br>
          <hr style="border:0;border-top:1px solid #c3e6cb;margin:4px 0 10px;">
          <p><strong>Tipos de ocorrência:</strong></p>
          <ul style="margin-left:16px;margin-top:6px;line-height:1.9;">
            <li><strong>Tolerância/Atraso</strong> — entrada fora do horário permitido.</li>
            <li><strong>Notificação</strong> — comunicado disciplinar ou pedagógico.</li>
            <li><strong>Fardamento</strong> — gera ocorrência direta imediata.</li>
          </ul>
        </div>
      </aside>
    </div>
  </main>

  <footer class="cookie">Direitos pertencentes a informática 3 2024-2026 | EEEP JOSÉ DE BARCELOS</footer>

  <script>
    let alunosCadastrados = [];

    async function loadAlunos() {
        try {
            const res = await fetch('api_cadastro.php');
            alunosCadastrados = await res.json();
        } catch (e) {
            showToast('Erro ao carregar lista de alunos', 'error');
        }
    }

    function showToast(msg, type = '') {
      const t = document.getElementById('toast');
      t.textContent = msg;
      t.className = 'toast ' + (type === 'error' ? 'error' : 'success');
      t.style.display = 'block';
      setTimeout(() => { t.style.display = 'none'; }, 3000);
    }

    function setHorarioAutomatico() {
      const agora = new Date();
      const horas = String(agora.getHours()).padStart(2, '0');
      const minutos = String(agora.getMinutes()).padStart(2, '0');
      const horario = `${horas}:${minutos}`;
      document.getElementById('horarioChegada').value = horario;
      document.getElementById('horarioSaida').value = horario;
    }

    function setDataAutomatica() {
      const agora = new Date();
      const ano = agora.getFullYear();
      const mes = String(agora.getMonth() + 1).padStart(2, '0');
      const dia = String(agora.getDate()).padStart(2, '0');
      const data = `${ano}-${mes}-${dia}`;
      document.getElementById('dataOcorrencia').value = data;
      document.getElementById('dataSaida').value = data;
    }

    function selectTipo(el, valor) {
      document.querySelectorAll('.box-tipo').forEach(b => b.classList.remove('active'));
      el.classList.add('active');
      document.getElementById('tipoOcorrenciaInput').value = valor;
      updateSaidaAntecipada();
    }

    function updateSaidaAntecipada() {
      const tipo = document.getElementById('tipoOcorrenciaInput').value;
      const saidaBox = document.getElementById('saidaAntecipadaFields');
      const ocorrenciaFields = document.getElementById('ocorrenciaFields');
      const motivoSelect = document.getElementById('motivoSaida');
      const outroBox = document.getElementById('outroMotivoBox');
      const outroText = document.getElementById('outroMotivo');

      if (tipo === 'Saída Antecipada') {
        saidaBox.style.display = 'block';
        ocorrenciaFields.style.display = 'none';
      } else {
        saidaBox.style.display = 'none';
        ocorrenciaFields.style.display = 'grid';
        motivoSelect.value = '';
        outroBox.style.display = 'none';
        outroText.value = '';
      }
    }

    function preencherAlunos() {
      const curso = document.getElementById('curso').value;
      const serie = document.getElementById('serie').value;
      const alunoSelect = document.getElementById('aluno');
      const responsavelBox = document.getElementById('responsavelBox');

      alunoSelect.innerHTML = '<option value="">Selecione o aluno...</option>';
      responsavelBox.style.display = 'none';
      responsavelBox.innerHTML = '';

      if (!curso || !serie) return;

      const alunos = alunosCadastrados.filter(a => a.curso === curso && a.turma === serie && a.status === 'Ativo');

      if(alunos.length === 0) {
        alunoSelect.innerHTML = '<option value="">Nenhum aluno ativo encontrado...</option>';
        return;
      }

      alunos.forEach(aluno => {
        const option = document.createElement('option');
        option.value = aluno.nome;
        option.textContent = `${aluno.matricula} - ${aluno.nome}`;
        option.dataset.matricula = aluno.matricula;
        alunoSelect.appendChild(option);
      });
    }

    function mostrarResponsavel() {
      const alunoNome = document.getElementById('aluno').value;
      const responsavelBox = document.getElementById('responsavelBox');

      if (!alunoNome) {
        responsavelBox.style.display = 'none';
        responsavelBox.innerHTML = '';
        return;
      }

      const aluno = alunosCadastrados.find(a => a.nome === alunoNome);
      if (!aluno) {
        responsavelBox.style.display = 'none';
        responsavelBox.innerHTML = '';
        return;
      }

      let htmlContent = `
        <strong>1º Responsável:</strong> ${aluno.resp_nome || '—'}<br>
        <strong>Telefone R1:</strong> ${aluno.resp_tel || '—'}<br>
        <strong>CPF R1:</strong> ${aluno.cpf_resp1 || '—'}
      `;

      if (aluno.resp2_nome) {
        htmlContent += `
          <hr style="border:0; border-top:1px dashed #dfe7df; margin:8px 0;">
          <strong>2º Responsável:</strong> ${aluno.resp2_nome}<br>
          <strong>Telefone R2:</strong> ${aluno.resp2_tel || '—'}<br>
          <strong>CPF R2:</strong> ${aluno.cpf_resp2 || '—'}
        `;
      }

      responsavelBox.innerHTML = htmlContent;
      responsavelBox.style.display = 'block';
    }

    document.getElementById('curso').addEventListener('change', preencherAlunos);
    document.getElementById('serie').addEventListener('change', preencherAlunos);
    document.getElementById('aluno').addEventListener('change', mostrarResponsavel);

    document.getElementById('motivoSaida').addEventListener('change', function () {
      const outroBox = document.getElementById('outroMotivoBox');
      if (this.value === 'Outros') outroBox.style.display = 'block';
      else {
        outroBox.style.display = 'none';
        document.getElementById('outroMotivo').value = '';
      }
    });

    window.addEventListener('load', function () {
      setHorarioAutomatico();
      setDataAutomatica();
      updateSaidaAntecipada();
      loadAlunos();
    });

    document.getElementById('formOcorrencia').addEventListener('submit', async function (e) {
      e.preventDefault();

      const form = new FormData(this);
      const tipo = document.getElementById('tipoOcorrenciaInput').value;
      const curso = form.get('curso');
      const serie = form.get('serie');
      const alunoNome = form.get('aluno');

      if (!curso || !serie || !alunoNome) {
        showToast('Preencha curso, série e aluno.', 'error');
        return;
      }

      const agora = new Date();
      const dataAtual = agora.toLocaleDateString('pt-BR');
      const horaAtual = agora.toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit' });

      const alunoObj = alunosCadastrados.find(a => a.nome === alunoNome);

      const registro = {
        id: Date.now(),
        tipo_ocorrencia: tipo,
        tipo: tipo === 'Tolerância' ? 'atraso' : (tipo === 'Notificação' ? 'ocorrencia' : 'info'),
        curso,
        turma: serie,
        aluno: alunoNome,
        matricula: alunoObj?.matricula || '',
        data: tipo === 'Saída Antecipada' ? form.get('data_saida') : form.get('data'),
        hora: tipo === 'Saída Antecipada' ? form.get('horario_saida') : form.get('horario'),
        motivo_saida: form.get('motivo_saida') || '',
        outro_motivo: form.get('outro_motivo') || '',
        observacoes: form.get('observacoes') || '',
        criado_em: dataAtual,
        criado_hora: horaAtual,
        lida: false
      };

      if (tipo === 'Saída Antecipada' && !registro.motivo_saida) {
        showToast('Selecione o motivo da saída antecipada.', 'error');
        return;
      }

      try {
          const res = await fetch('api_registro.php', {
              method: 'POST',
              headers: { 'Content-Type': 'application/json' },
              body: JSON.stringify(registro)
          });
          const data = await res.json();
          
          if (data.success) {
              showToast('Ocorrência registrada com sucesso!');
              setTimeout(() => {
                this.reset();
                document.querySelectorAll('.box-tipo').forEach((b, i) => b.classList.toggle('active', i === 0));
                document.getElementById('tipoOcorrenciaInput').value = 'Tolerância';
                setHorarioAutomatico();
                setDataAutomatica();
                updateSaidaAntecipada();
                preencherAlunos();
                document.getElementById('responsavelBox').style.display = 'none';
                document.getElementById('responsavelBox').innerHTML = '';
              }, 500);
          } else {
              showToast(data.message || 'Erro ao registrar.', 'error');
          }
      } catch(e) {
          showToast('Erro de conexão.', 'error');
      }
    });
  </script>
</body>
</html>
