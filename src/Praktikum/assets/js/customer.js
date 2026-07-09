const PIZZA_STATUS    = ['Bestellt', 'Im Ofen', 'Fertig'];
const DELIVERY_STATUS = ['Wird vorbereitet', 'Unterwegs', 'Geliefert'];

// Escape untrusted strings before inserting into innerHTML  :: Security 
function escapeHtml(str) {
    return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#39;');
}
// API fetching : async & await 
async function requestData() {      // Every 2 seconds, JavaScript silently sends a request to api
    try {
        const response = await fetch('api');    // Waits for server to respond to fetch('api')
        if (!response.ok) throw new Error(`Fehler: ${response.status}`);
        const data = await response.json();
        process(data);
    } catch (error) {
        console.error('Übertragung fehlgeschlagen:', error);
    }
}

function process(data) {    // CSR
    const container = document.getElementById('order');      //Id selector :    Find elements on the page

    if (!data.ordering_id) {
        container.innerHTML = '<p>Keine aktive Bestellung gefunden.</p>';    // Writing the DOM
        return;
    }

    const pizzaRows = data.pizzas.map(p => {
        const label = PIZZA_STATUS[p.status] ?? 'Unbekannt';
        return `<tr><td>${escapeHtml(p.name)}</td><td>${escapeHtml(label)}</td></tr>`;
    }).join('');

    const deliveryLabel = escapeHtml(DELIVERY_STATUS[data.delivery_status] ?? 'Unbekannt');

    // Replace entire section content :
    container.innerHTML = `     
        <h2>Bestellung #${escapeHtml(String(data.ordering_id))}</h2>
        <p><strong>Adresse:</strong> ${escapeHtml(data.address)}</p>
        <table>
            <thead><tr><th>Pizza</th><th>Status</th></tr></thead>
            <tbody>${pizzaRows}</tbody>
        </table>
        <p><strong>Lieferstatus:</strong> ${deliveryLabel}</p>
    `;
}

// Pooling
document.addEventListener('DOMContentLoaded', () => {    // Wait for the page to fully load
    requestData();                                      // Updates the page without reloads
    setInterval(requestData, 2000);
});
