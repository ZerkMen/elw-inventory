// Speichern Sie diese Datei unter: public/assets/js/dashboard.js

const { useState, useEffect } = React;
const { BarChart, Bar, XAxis, YAxis, CartesianGrid, Tooltip, Legend, ResponsiveContainer } = Recharts;

const MetricCard = ({ title, value }) => (
  <div className="bg-white p-4 rounded shadow">
    <h3 className="font-bold">{title}</h3>
    <p className="text-2xl">{value}</p>
  </div>
);

const Dashboard = ({ initialData }) => {
  const [data, setData] = useState(initialData);

  useEffect(() => {
    // Hier könnten Sie in Zukunft eine Echtzeit-Aktualisierung implementieren
  }, []);

  return (
    <div className="p-4">
      <h1 className="text-2xl font-bold mb-4">Lagerverwaltungs-Dashboard</h1>
      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <MetricCard title="Gesamtprodukte" value={data.totalProducts} />
        <MetricCard title="Produkte mit niedrigem Bestand" value={data.lowStockProducts} />
        <MetricCard title="Gesamtbestellungen" value={data.totalOrders} />
        <MetricCard title="Umsatz" value={`€${data.revenue.toLocaleString()}`} />
      </div>
      <div className="bg-white p-4 rounded shadow mb-8">
        <h2 className="font-bold mb-4">Top 5 Produkte nach Verkäufen</h2>
        <ResponsiveContainer width="100%" height={300}>
          <BarChart data={data.topProducts}>
            <CartesianGrid strokeDasharray="3 3" />
            <XAxis dataKey="name" />
            <YAxis />
            <Tooltip />
            <Legend />
            <Bar dataKey="sales" fill="#8884d8" />
          </BarChart>
        </ResponsiveContainer>
      </div>
    </div>
  );
};
