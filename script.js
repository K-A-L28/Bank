function accion(tipo) {
    const monto = document.getElementById('monto').value;
    fetch('acciones.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: `tipo=${tipo}&monto=${monto}`
    })
      .then(res => res.json())
      .then(data => {
        document.getElementById('saldo').innerText = `Saldo actual: $${data.saldo}`;
        document.getElementById('mensaje').innerText = data.mensaje;
      });
  }
  