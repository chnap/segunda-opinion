document.addEventListener("DOMContentLoaded", () => {
  // Inyectar estilos CSS globales con !important para forzar el tema claro sobre el HTML del backend
  const forcedLightStyles = document.createElement("style");
  forcedLightStyles.innerHTML = `
    body, html {
      background-color: #f8fafc !important;
      color: #1e293b !important;
    }
    
    /* Forzar contenedores oscuros a blanco/claro */
    .bg-slate-900, .bg-slate-950, .bg-slate-900\\/80, .bg-slate-950\\/80, 
    header, nav, div[class*="bg-slate-9"] {
      background-color: #ffffff !important;
      color: #1e293b !important;
      border-color: #e2e8f0 !important;
    }

    /* Forzar colores de texto para legibilidad perfecta */
    .text-white {
      color: #0f172a !important;
    }
    .text-slate-300, .text-slate-400, .text-slate-500 {
      color: #64748b !important;
    }

    /* Tarjetas, tablas y bordes */
    table, th, td {
      border-color: #e2e8f0 !important;
    }
    tr:hover {
      background-color: #f8fafc !important;
    }
  `;
  document.head.appendChild(forcedLightStyles);

  if (window.lucide) lucide.createIcons();

  if (window.gsap) {
    gsap.from(".fade-in", {
      duration: 0.6,
      y: 15,
      opacity: 0,
      stagger: 0.08,
      ease: "power2.out",
    });
  }

  const DEFAULT_CHECKLIST_TEMPLATE = [
    { id: "medical_report", name: "Diagnóstico" },
    {
      id: "pathology",
      name: "Anatomía patológica completa e inmunohistoquímica",
    },
    { id: "imaging", name: "Informes de pruebas de imagen (TAC, RM, PET-TC)" },
    { id: "treatments", name: "Relación de tratamientos oncológicos previos" },
    { id: "labs", name: "Analítica reciente (últimos 1-2 meses)" },
    { id: "patient_question", name: "Pregunta o dudas concretas del paciente" },
  ];

  function createChecklist(statuses = {}, caseData = {}) {
    const hasDiagnosis = Boolean(caseData.diagnosis || caseData.pathology);
    const hasQuestion = Boolean(
      caseData.patientQuestion || caseData.clinical_question,
    );

    return DEFAULT_CHECKLIST_TEMPLATE.map((item) => {
      let status = statuses[item.id];
      if (!status) {
        if (item.id === "medical_report" && hasDiagnosis) status = "Aportado";
        else if (item.id === "patient_question" && hasQuestion)
          status = "Aportado";
        else status = "Pendiente";
      }
      return { ...item, status };
    });
  }

  const DEFAULT_CASES = [
    {
      id: "ONC-8021",
      priority: "ALTA",
      patient: "Carmen Martínez López",
      subtext: "carmen.martinez@example.com • +34 600 11 22 33",
      pathology: "Carcinoma ductal infiltrante de mama estadio IIA",
      patientQuestion:
        "¿Es aconsejable tratamiento de hormonoterapia adyuvante?",
      status: "NEW_REQUEST",
      updatedAt: "19/08/2026, 07:51",
      dricloudUrl: "https://pagoseguro.dricloud.net/?URL=dricloud_onc8021",
      checklist: createChecklist(
        {},
        {
          diagnosis: "Carcinoma ductal",
          clinical_question: "¿Es aconsejable...?",
        },
      ),
    },
    {
      id: "ONC-8020",
      priority: "NORMAL",
      patient: "Antonio Gómez Ruiz",
      subtext: "antonio.gomez@example.com • +34 611 22 33 44",
      pathology: "Adenocarcinoma de pulmón estadificación T2N1M0",
      patientQuestion: "Valoración sobre opciones de inmunoterapia combinada.",
      status: "ACCEPTED",
      updatedAt: "18/08/2026, 15:51",
      dricloudUrl: "https://pagoseguro.dricloud.net/?URL=dricloud_onc8020",
      checklist: createChecklist(
        {
          pathology: "Aportado",
          imaging: "Aportado",
          treatments: "Aportado",
          labs: "Aportado",
        },
        { diagnosis: "Adenocarcinoma", clinical_question: "Valoración..." },
      ),
    },
  ];

  let cases = [];
  let currentFilter = "ALL";
  let searchQuery = "";

  const casesBody = document.getElementById("casesBody");
  const searchInput = document.getElementById("caseSearch");
  const filterButtons = document.querySelectorAll(".filter");
  const modal = document.getElementById("caseModal");
  const modalContent = document.getElementById("modalContent");
  const closeModal = document.getElementById("closeModal");
  const resetBtn = document.getElementById("resetDemo");

  async function loadCasesFromDB() {
    try {
      const response = await fetch("api.php?action=get_cases");
      const data = await response.json();
      if (data.ok && Array.isArray(data.cases) && data.cases.length > 0) {
        cases = data.cases.map((c) => {
          const statusMap = {};
          if (Array.isArray(c.checklist)) {
            c.checklist.forEach((i) => {
              if (i && i.id) statusMap[i.id] = i.status;
            });
          }
          return {
            ...c,
            checklist: createChecklist(statusMap, {
              diagnosis: c.pathology || c.diagnosis,
              clinical_question: c.patientQuestion || c.clinical_question,
            }),
          };
        });
      } else {
        cases = DEFAULT_CASES;
      }
    } catch (error) {
      console.error(
        "Error al conectar con la base de datos, usando datos predeterminados:",
        error,
      );
      cases = DEFAULT_CASES;
    }
    renderCases();
  }

  function showToast(message) {
    let toast = document.getElementById("toastNotification");
    if (!toast) {
      toast = document.createElement("div");
      toast.id = "toastNotification";
      toast.className =
        "fixed bottom-5 right-5 bg-white text-slate-800 border border-slate-200 px-4 py-3 rounded-xl shadow-xl text-xs font-semibold backdrop-blur-md transition-all duration-300 transform translate-y-10 opacity-0 z-50 flex items-center gap-2";
      document.body.appendChild(toast);
    }
    toast.innerHTML = `<i data-lucide="check-circle" class="w-4 h-4 text-slate-600"></i> ${message}`;
    if (window.lucide) lucide.createIcons();
    toast.classList.remove("translate-y-10", "opacity-0");
    setTimeout(() => {
      toast.classList.add("translate-y-10", "opacity-0");
    }, 3500);
  }

  function getMissingSummary(c) {
    if (!c || !c.checklist || !Array.isArray(c.checklist))
      return '<span class="missing-badge missing-badge--empty">Sin datos</span>';
    const missing = c.checklist.filter(
      (item) => item && item.status === "Pendiente",
    );
    if (missing.length === 0) {
      return '<span class="missing-badge missing-badge--complete"><i data-lucide="check" class="w-3.5 h-3.5"></i> Completo</span>';
    }
    const details = missing.map((item) => item.name).join("\n");
    return `<span class="missing-badge missing-badge--pending" tabindex="0" aria-label="${missing.length} documentos pendientes. ${details}">
      <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i> ${missing.length} pendiente${missing.length === 1 ? "" : "s"}
      <span class="missing-popover" role="tooltip"><strong>Documentación pendiente</strong><span>${missing.map((item) => item.name).join("<br>")}</span></span>
    </span>`;
  }

  function getNextActionHTML(c) {
    if (c.status === "NEW_REQUEST") {
      return `<button onclick="openCaseModal('${c.id}')" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-900 font-bold rounded-xl text-xs transition inline-flex items-center gap-1.5 shadow-sm cursor-pointer border border-slate-300">
                <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i> Realizar Triaje
            </button>`;
    } else if (c.status === "ACCEPTED") {
      return `<button onclick="openCaseModal('${c.id}')" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-900 font-bold rounded-xl text-xs transition inline-flex items-center gap-1.5 shadow-sm cursor-pointer border border-slate-300">
                <i data-lucide="stethoscope" class="w-3.5 h-3.5"></i> Ver Consulta
            </button>`;
    } else if (c.status === "REJECTED") {
      return `<span class="text-xs text-slate-600 font-semibold">Caso Archivado</span>`;
    } else {
      return `<button onclick="openCaseModal('${c.id}')" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold rounded-xl text-xs transition inline-flex items-center gap-1.5 shadow-sm cursor-pointer border border-slate-300">
                <i data-lucide="eye" class="w-3.5 h-3.5"></i> Revisar Caso
            </button>`;
    }
  }

  function getPriorityBadgeHTML(priority) {
    if (priority === "ALTA" || priority === "Urgente") {
      return `<span class="soft-badge priority-badge priority-badge--urgent">URGENTE</span>`;
    }
    return `<span class="soft-badge priority-badge priority-badge--normal">NORMAL</span>`;
  }

  function getStatusBadgeHTML(status) {
    switch (status) {
      case "REJECTED":
        return `<span class="soft-badge status-badge status-badge--rejected">Denegado</span>`;
      case "NEW_REQUEST":
        return `<span class="soft-badge status-badge status-badge--new">Nueva Solicitud</span>`;
      case "ACCEPTED":
        return `<span class="soft-badge status-badge status-badge--accepted">Aceptado</span>`;
      case "DOCUMENTATION_PENDING":
        return `<span class="soft-badge status-badge status-badge--documentation">Falta Documentación</span>`;
      default:
        return `<span class="soft-badge status-badge status-badge--progress">En curso</span>`;
    }
  }

  function formatEventDate(value) {
    if (!value) return "Fecha no disponible";
    const date = new Date(String(value).replace(" ", "T"));
    if (Number.isNaN(date.getTime())) return value;
    return new Intl.DateTimeFormat("es-ES", {
      dateStyle: "medium",
      timeStyle: "short",
    }).format(date);
  }

  function getEventLabel(event) {
    const labels = {
      NEW_REQUEST: "Nueva solicitud recibida",
      REQUEST_SUBMITTED: "Solicitud creada",
      SOLICITUD_CREADA: "Solicitud creada",
      DOCUMENTATION_UPDATED: "Documentación actualizada",
      ACCEPTED: "Caso aceptado",
      REJECTED: "Caso denegado",
    };
    return labels[event.type] || event.label || event.type || "Actividad registrada";
  }

  function getTimelineHTML(c) {
    const events = Array.isArray(c.events) ? c.events : [];
    if (!events.length) {
      return `<section class="activity-panel" aria-labelledby="activityTitle"><div class="activity-heading"><span class="activity-kicker">Trazabilidad</span><h4 id="activityTitle">Historial de Actividad</h4></div><p class="activity-empty">Todavía no hay actividad registrada para este expediente.</p></section>`;
    }
    return `<section class="activity-panel" aria-labelledby="activityTitle">
      <div class="activity-heading"><span class="activity-kicker">Trazabilidad</span><h4 id="activityTitle">Historial de Actividad</h4></div>
      <ol class="activity-timeline">${events.map((event) => `<li class="activity-event"><span class="activity-dot" aria-hidden="true"></span><div><p class="activity-event-title">${getEventLabel(event)}</p><p class="activity-event-meta">${formatEventDate(event.at || event.created_at)}${event.actor ? ` · ${event.actor}` : ""}</p>${event.metadata ? `<p class="activity-event-detail">${event.metadata}</p>` : ""}</div></li>`).join("")}</ol>
    </section>`;
  }

  function renderCases() {
    if (!casesBody) return;

    let filtered = cases.filter((c) => {
      if (!c) return false;
      let matchesFilter = true;
      if (currentFilter === "URGENT")
        matchesFilter = c.priority === "ALTA" || c.priority === "Urgente";
      else if (currentFilter === "PENDING_TRIAGE")
        matchesFilter = c.status === "NEW_REQUEST";
      else if (currentFilter === "DOCUMENTATION_PENDING")
        matchesFilter =
          c.checklist &&
          c.checklist.some((i) => i.status === "Pendiente") &&
          c.status !== "REJECTED";
      else if (currentFilter === "READY_FOR_CONSULTATION")
        matchesFilter = c.status === "ACCEPTED";
      else if (currentFilter === "REJECTED")
        matchesFilter = c.status === "REJECTED";

      const patientName = c.patient || c.patientName || "";
      const pathology = c.pathology || c.diagnosis || "";
      const query = searchQuery.toLowerCase();
      return (
        matchesFilter &&
        (patientName.toLowerCase().includes(query) ||
          pathology.toLowerCase().includes(query))
      );
    });

    if (filtered.length === 0) {
      casesBody.innerHTML = `<tr><td colspan="6" class="py-12 text-center text-slate-500 text-sm">No hay casos que coincidan con los filtros seleccionados.</td></tr>`;
      return;
    }

    casesBody.innerHTML = filtered
      .map((c) => {
        const patientName = c.patient || c.patientName || "Sin Nombre";
        const pathology =
          c.pathology || c.diagnosis || "Pendiente de diagnóstico";
        const caseId = c.id || "ONC-0000";
        const priority = c.priority || "NORMAL";

        if (!Array.isArray(c.checklist)) {
          c.checklist = createChecklist(
            {},
            { diagnosis: pathology, clinical_question: c.patientQuestion },
          );
        }

        return `
            <tr onclick="openCaseModal('${caseId}')" class="hover:bg-slate-50 transition-colors border-b border-slate-200 cursor-pointer group">
                <td class="py-4 px-6">${getPriorityBadgeHTML(priority)}</td>
                <td class="py-4 px-6">
                    <div class="font-bold text-slate-900 group-hover:text-slate-500 transition-colors text-sm">${patientName}</div>
                    <div class="text-[11px] text-slate-500">${c.subtext || ""}</div>
                </td>
                <td class="py-4 px-6 text-xs text-slate-800 max-w-xs truncate">${pathology}</td>
                <td class="py-4 px-6">${getStatusBadgeHTML(c.status)}</td>
                <td class="py-4 px-6 text-xs max-w-xs">${getMissingSummary(c)}</td>
                <td class="py-4 px-6 text-right" onclick="event.stopPropagation()">
                    ${getNextActionHTML(c)}
                </td>
            </tr>
            `;
      })
      .join("");

    if (window.lucide) lucide.createIcons();
  }

  window.openCaseModal = function (id) {
    const c = cases.find((item) => item && item.id === id);
    if (!c || !modal || !modalContent) return;

    if (!Array.isArray(c.checklist)) {
      c.checklist = createChecklist(
        {},
        {
          diagnosis: c.pathology || c.diagnosis,
          clinical_question: c.patientQuestion || c.clinical_question,
        },
      );
    }

    const patientName = c.patient || c.patientName || "Sin Nombre";
    const pathology = c.pathology || c.diagnosis || "Pendiente de diagnóstico";
    const question =
      c.patientQuestion || c.clinical_question || "Sin consulta registrada";

    let decisionSectionHTML = "";

    if (c.status === "ACCEPTED") {
      decisionSectionHTML = `
                <div class="bg-white p-4 rounded-xl border border-slate-200 space-y-3 shadow-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-700">Acción Realizada: Caso Aceptado</span>
                        <i data-lucide="check-circle-2" class="w-5 h-5 text-slate-600"></i>
                    </div>
                    <p class="text-xs text-slate-700">Se han enviado las instrucciones de acceso al formulario oficial por correo.</p>
                    <button onclick="resendEmail('${c.id}')" class="w-full py-2.5 bg-slate-50 hover:bg-slate-100 text-slate-900 rounded-xl text-xs font-bold transition flex items-center justify-center gap-2 cursor-pointer shadow-sm">
                        <i data-lucide="mail-check" class="w-4 h-4"></i>
                        <span>Reenviar Enlace de Acceso</span>
                    </button>
                </div>
            `;
    } else if (c.status === "REJECTED") {
      decisionSectionHTML = `
                <div class="bg-white p-4 rounded-xl border border-slate-200 space-y-3 shadow-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-700">Acción Realizada: Caso Denegado</span>
                        <i data-lucide="x-circle" class="w-5 h-5 text-slate-600"></i>
                    </div>
                    <p class="text-xs text-slate-700">${c.rejectionReason ? "Motivo: " + c.rejectionReason : "Sin motivo registrado."}</p>
                </div>
            `;
    } else {
      decisionSectionHTML = `
                <div class="bg-white p-4 rounded-xl border border-slate-200 space-y-3 shadow-sm">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-800 block border-b border-slate-200 pb-2">Próxima Acción Médica (Triaje)</span>
                    <div class="grid grid-cols-2 gap-2">
                        <button onclick="acceptCaseHandler('${c.id}')" class="px-3 py-3 bg-slate-50 hover:bg-slate-100 text-slate-900 rounded-xl text-xs font-bold transition flex items-center justify-center gap-1.5 cursor-pointer shadow-sm">
                            <i data-lucide="check" class="w-4 h-4"></i> Aceptar Caso
                        </button>
                        <button onclick="toggleDenyBox('${c.id}')" class="px-3 py-3 bg-slate-50 hover:bg-slate-100 text-slate-800 border border-slate-300 rounded-xl text-xs font-bold transition flex items-center justify-center gap-1.5 cursor-pointer shadow-sm">
                            <i data-lucide="x" class="w-4 h-4"></i> Denegar Caso
                        </button>
                    </div>

                    <div id="denyBox_${c.id}" class="hidden space-y-2.5 pt-2 border-t border-slate-200">
                        <label class="block text-[11px] font-semibold text-slate-700 uppercase tracking-wider">Motivo de la denegación para el paciente</label>
                        <textarea id="denyReasonText_${c.id}" rows="3" placeholder="Explique brevemente el motivo..." class="w-full bg-slate-50 border border-slate-300 rounded-xl p-2.5 text-xs text-slate-900 focus:outline-none focus:border-slate-500"></textarea>
                        <button onclick="submitDenial('${c.id}')" class="w-full py-2 bg-slate-100 hover:bg-slate-200 text-slate-900 rounded-xl text-xs font-bold transition cursor-pointer shadow-sm">
                            Confirmar y Enviar Notificación
                        </button>
                    </div>
                </div>
            `;
    }

    modalContent.innerHTML = `
            <div class="bg-white p-4 rounded-xl border border-slate-200 mb-4 flex flex-wrap items-center justify-between gap-3 shadow-sm">
                <div>
                    <h3 class="text-lg font-bold text-slate-900 font-serif">${patientName}</h3>
                    <p class="text-xs text-slate-500 mt-0.5">${c.subtext || ""}</p>
                </div>
                <div>${getStatusBadgeHTML(c.status)}</div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">
                <div class="lg:col-span-7 space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="bg-white p-3.5 rounded-xl border border-slate-200 shadow-sm">
                            <span class="text-[10px] uppercase font-bold text-slate-500 tracking-wider block mb-1">Patología / Diagnóstico</span>
                            <p class="text-xs text-slate-800 font-medium">${pathology}</p>
                        </div>
                        <div class="bg-white p-3.5 rounded-xl border border-slate-200 shadow-sm">
                            <span class="text-[10px] uppercase font-bold text-slate-500 tracking-wider block mb-1">Pregunta del Paciente</span>
                            <p class="text-xs text-slate-800 font-medium">${question}</p>
                        </div>
                    </div>

                    <div class="bg-white p-4 rounded-xl border border-slate-200 space-y-3 shadow-sm">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-800 block border-b border-slate-200 pb-2">Documentación Requerida</span>
                        <div class="space-y-2 max-h-[280px] overflow-y-auto pr-1">
                            ${c.checklist
                              .map((doc) => {
                                const isExempt =
                                  doc.id === "patient_question" ||
                                  doc.id === "pathology";
                                return `
                                    <div class="flex items-center justify-between p-2.5 rounded-lg bg-slate-50 border border-slate-200 gap-2">
                                        <span class="text-xs text-slate-800">${doc.name}</span>
                                        <div class="inline-flex rounded-lg bg-white p-0.5 border border-slate-200 shrink-0 shadow-sm">
                                            <button onclick="setDocStatus('${c.id}', '${doc.id}', 'Aportado')" class="px-2 py-0.5 text-[10px] font-semibold rounded cursor-pointer ${doc.status === "Aportado" ? "bg-slate-100 text-slate-900 border border-slate-300 font-bold" : "text-slate-600 hover:text-slate-900"}">Aportado</button>
                                            <button onclick="setDocStatus('${c.id}', '${doc.id}', 'Pendiente')" class="px-2 py-0.5 text-[10px] font-semibold rounded cursor-pointer ${doc.status === "Pendiente" ? "bg-slate-100 text-slate-900 border border-slate-300 font-bold" : "text-slate-600 hover:text-slate-900"}">Pendiente</button>
                                            ${!isExempt ? `<button onclick="setDocStatus('${c.id}', '${doc.id}', 'No requerida')" class="px-2 py-0.5 text-[10px] font-semibold rounded cursor-pointer ${doc.status === "No requerida" ? "bg-slate-200 text-slate-800 border border-slate-300 font-bold" : "text-slate-600 hover:text-slate-900"}">No requerida</button>` : ""}
                                        </div>
                                    </div>
                                `;
                              })
                              .join("")}
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-5 space-y-4">
                    ${decisionSectionHTML}
                </div>
            </div>
            ${getTimelineHTML(c)}
        `;

    modal.classList.remove("opacity-0", "pointer-events-none");
    const modalInner = modal.querySelector(".modal");
    if (modalInner) {
      modalInner.classList.remove("scale-95");
      modalInner.classList.add("scale-100");
    }
    if (window.lucide) lucide.createIcons();
  };

  window.closeModalHandler = function () {
    if (!modal) return;
    modal.classList.add("opacity-0", "pointer-events-none");
    const modalInner = modal.querySelector(".modal");
    if (modalInner) {
      modalInner.classList.remove("scale-100");
      modalInner.classList.add("scale-95");
    }
  };

  window.setDocStatus = function (caseId, docId, newStatus) {
    const c = cases.find((item) => item.id === caseId);
    if (c) {
      const docItem = c.checklist.find((d) => d.id === docId);
      if (docItem) {
        docItem.status = newStatus;

        fetch("api.php?action=update_checklist", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ caseId, checklist: c.checklist }),
        }).catch(() => {});

        renderCases();
        openCaseModal(caseId);
      }
    }
  };

  window.acceptCaseHandler = function (caseId) {
    updateCaseDecision(caseId, "ACCEPTED");
  };
  window.toggleDenyBox = function (caseId) {
    const box = document.getElementById(`denyBox_${caseId}`);
    if (box) box.classList.toggle("hidden");
  };
  window.submitDenial = function (caseId) {
    const reasonInput = document.getElementById(`denyReasonText_${caseId}`);
    const reason = reasonInput ? reasonInput.value.trim() : "";
    if (!reason) {
      alert("Indique el motivo de la denegación.");
      return;
    }
    updateCaseDecision(caseId, "REJECTED", reason);
  };

  window.updateCaseDecision = function (caseId, newStatus, reason = "") {
    const c = cases.find((item) => item.id === caseId);
    if (c) {
      c.status = newStatus;
      if (reason) c.rejectionReason = reason;

      const endpoint = newStatus === "ACCEPTED" ? "accept_case" : "reject_case";
      fetch(`api.php?action=${endpoint}`, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ caseId, reason }),
      }).catch(() => {});

      showToast(
        newStatus === "ACCEPTED"
          ? "Caso aceptado correctamente."
          : "Caso denegado correctamente.",
      );
      renderCases();
      openCaseModal(caseId);
    }
  };

  window.resendEmail = function (caseId) {
    fetch("api.php?action=resend_email", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ caseId }),
    }).catch(() => {});
    showToast("Enlace reenviado con éxito.");
  };

  if (closeModal)
    closeModal.addEventListener("click", window.closeModalHandler);
  if (modal)
    modal.addEventListener("click", (e) => {
      if (e.target === modal) window.closeModalHandler();
    });
  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape") {
      if (typeof window.closeModalHandler === "function") {
        window.closeModalHandler();
      }
    }
  });
  filterButtons.forEach((btn) => {
    btn.addEventListener("click", () => {
      filterButtons.forEach((b) =>
        b.classList.remove("active", "border-accent", "text-accent"),
      );
      btn.classList.add("active");
      currentFilter = btn.getAttribute("data-filter") || "ALL";
      renderCases();
    });
  });

  if (searchInput) {
    searchInput.addEventListener("input", (e) => {
      searchQuery = e.target.value;
      renderCases();
    });
  }

  if (resetBtn) {
    resetBtn.addEventListener("click", async () => {
      try {
        await fetch("api.php?action=reset_demo");
        await loadCasesFromDB();
        showToast("Datos sincronizados con la base de datos");
      } catch (e) {
        showToast("Datos restablecidos");
      }
    });
  }

  loadCasesFromDB();
});
