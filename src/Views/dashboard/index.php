<?php
// Stellen Sie sicher, dass diese Variablen von Ihrem Controller gesetzt werden
$totalProducts = $totalProducts ?? 0;
$lowStockProducts = $lowStockProducts ?? 0;
$totalOrders = $totalOrders ?? 0;
$recentOrders = $recentOrders ?? [];
$totalCustomers = $totalCustomers ?? 0;
$totalRevenue = $totalRevenue ?? 0;
?>

<style>
  .metric-card {
    height: 100%;
    min-height: 150px;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
  }
  .metric-card .card-content {
    padding-top: 1.5rem;
  }
</style>

<div id="dashboard-root"></div>
<script src="https://unpkg.com/react@17/umd/react.development.js"></script>
<script src="https://unpkg.com/react-dom@17/umd/react-dom.development.js"></script>
<script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>
<script type="text/babel">
const dashboardData = <?php echo json_encode(compact('totalProducts', 'lowStockProducts', 'totalOrders', 'recentOrders', 'totalCustomers', 'totalRevenue')); ?>;

console.log('Dashboard Data:', dashboardData);

class ErrorBoundary extends React.Component {
  constructor(props) {
    super(props);
    this.state = { hasError: false };
  }

  static getDerivedStateFromError(error) {
    return { hasError: true };
  }

  componentDidCatch(error, errorInfo) {
    console.log('Dashboard Error:', error, errorInfo);
  }

  render() {
    if (this.state.hasError) {
      return <h1>Es gab ein Problem beim Laden des Dashboards.</h1>;
    }

    return this.props.children;
  }
}

const MetricCard = ({ title, value, icon }) => (
  <div className="card metric-card">
    <div className="card-content">
      <div className="media">
        <div className="media-left">
          <figure className="image is-48x48">
            <i className={`fas fa-${icon} fa-2x`}></i>
          </figure>
        </div>
        <div className="media-content">
          <p className="title is-4">{value}</p>
          <p className="subtitle is-6">{title}</p>
        </div>
      </div>
    </div>
  </div>
);

const RecentOrdersTable = ({ orders }) => (
  <table className="table is-fullwidth is-striped">
    <thead>
      <tr>
        <th>ID</th>
        <th>Kunde</th>
        <th>Betrag</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      {orders.map(order => (
        <tr key={order.id}>
          <td>{order.id}</td>
          <td>{order.customer_name}</td>
          <td>{order.total_amount}</td>
          <td>
            <span className={`tag ${order.status === 'completed' ? 'is-success' : 'is-warning'}`}>
              {order.status}
            </span>
          </td>
        </tr>
      ))}
    </tbody>
  </table>
);

const Dashboard = ({ initialData }) => {
  const [data, setData] = React.useState(initialData);

  return (
    <section className="section">
      <h1 className="title">Dashboard</h1>
      <div className="columns">
        <div className="column">
          <MetricCard title="Gesamtprodukte" value={data.totalProducts} icon="box" />
        </div>
        <div className="column">
          {data.lowStockProducts > 0 ? (
            <MetricCard title="Produkte mit kritischem Bestand" value={data.lowStockProducts} icon="exclamation-triangle" />
          ) : (
            <MetricCard title="Keine Produkte mit kritischem Bestand" value="" icon="check-circle" />
          )}
        </div>
        <div className="column">
          <MetricCard title="Gesamtbestellungen" value={data.totalOrders} icon="shopping-cart" />
        </div>
        <div className="column">
          <MetricCard title="Gesamtkunden" value={data.totalCustomers} icon="users" />
        </div>
        <div className="column">
          <MetricCard title="Gesamtumsatz" value={`€${parseFloat(data.totalRevenue).toFixed(2)}`} icon="money-bill-alt" />
        </div>
      </div>
      <div className="box">
        <h2 className="subtitle">Letzte Bestellungen</h2>
        <RecentOrdersTable orders={data.recentOrders || []} />
      </div>
    </section>
  );
};

ReactDOM.render(
  <ErrorBoundary>
    <Dashboard initialData={dashboardData} />
  </ErrorBoundary>,
  document.getElementById('dashboard-root')
);
</script>