@section('scripts')
@parent
<script type="text/javascript">
  var __logs__ = {
    'LOGS': [],
    'ERRORS': [],
    'QUERIES': [],
    'SESSIONS': [],
    'MEMORY, EXECUTION': []
  };

  var __logs__styles__ = {
    'LOGS': 'color:#999',
    'ERRORS': 'color:#fe3d3c',
    'QUERIES': 'color:#3baea3',
    'SESSIONS': 'color:#3320AD',
    'MEMORY, EXECUTION': 'color:#ffa532'
  };

  var __logs__timer__ = false;

  $Event.on('api.serverlogged', function(logs) {
    if (!logs) return;

    logs = JSON.parse(logs);
    for (var key in logs) {
      if (key == 'SESSIONS' || key == 'MEMORY, EXECUTION') {
        __logs__[key] = logs[key];
      } else {
        for (var i in logs[key]) {
          __logs__[key].push(logs[key][i]);
        }
      }
    }
    clearTimeout(__logs__timer__);
    __logs__timer__ = setTimeout(function() {
      // console.clear();
      console.group('%cDEBUG SERVER', 'color:#4d8fff;font-size:18px');
      for (var name in __logs__) {
        console.groupCollapsed('%c' + name, __logs__styles__[name] + ';font-size:16px');
        for (var j in __logs__[name]) {
          console.log.apply(console, __logs__[name][j]);
        }
        console.groupEnd();
      }
      console.groupEnd();
      __logs__ = {
        'LOGS': [],
        'ERRORS': [],
        'QUERIES': [],
        'SESSIONS': [],
        'MEMORY, EXECUTION': []
      };
    }, 1000);
  });

  window.addEventListener('online', function() {
    window.location.reload();
  });

  window.addEventListener('offline', function() {
    document.querySelector('head').innerHTML = '<meta charset="utf-8" /><meta http-equiv="X-UA-Compatible" content="IE=edge" /><meta name="viewport" content="width=device-width, initial-scale=1" /><title>You are offline</title><style type="text/css">body{margin:0;}.offline-wrapper{display:flex;min-height:100vh;align-items:center;flex-direction:column;justify-content:center;background-color:#292E3F;transform: translateY(-100vh);transition: transform 0.25s ease;font-family:helvetica,arial,sans-serif;}.offline-image{width:10rem;display:flex;align-items:center;justify-content:center;}.offline-content{display:flex;color:#ffffff;margin:1.5rem 0;align-items:center;flex-direction:column;}.offline-content h1{margin:0;margin-bottom:1rem;}.offline-content p{margin:0;}.offline-button{opacity:0.8;outline:none;color:#ffffff;font-size:1rem;cursor:pointer;font-weight:400;background:none;user-select:none;text-align:center;align-self:center;white-space:nowrap;padding:0.75rem 1.5rem;display:inline-block;border-radius:5rem;vertical-align:middle;text-overflow:ellipsis;border:1px solid #ffffff;}.offline-button:hover{opacity:1;}</style>';

    document.querySelector('body').innerHTML = '<div class="offline-wrapper"><div class="offline-image"><svg width="100%" height="100%" viewBox="0 0 743 568" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" xmlns:serif="http://www.serif.com/" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;"><g transform="matrix(1,0,0,1,-1717.16,-2238.18)"><path fill="#ffffff" d="M2092.2,2684.72C2125.71,2684.72 2152.91,2711.93 2152.91,2745.44C2152.91,2778.95 2125.71,2806.16 2092.2,2806.16C2058.69,2806.16 2031.48,2778.95 2031.48,2745.44C2031.48,2711.93 2058.69,2684.72 2092.2,2684.72ZM2253.42,2328.65C2200.18,2309.78 2146.65,2300.33 2092.89,2300.2C1973.28,2299.93 1851.89,2345.89 1729.31,2440.54C1715.66,2451.08 1713.13,2470.72 1723.67,2484.37C1734.21,2498.03 1753.85,2500.55 1767.5,2490.01C1877.36,2405.19 1985.56,2362.46 2092.74,2362.7C2131.84,2362.79 2170.72,2368.61 2209.41,2380.05L2167.92,2428.51C2145.7,2424.14 2123.42,2421.93 2101.09,2421.88C2012.19,2421.68 1921.89,2455.63 1830.78,2525.97C1817.13,2536.51 1814.61,2556.16 1825.15,2569.81C1835.69,2583.46 1855.33,2585.98 1868.98,2575.44C1947.36,2514.92 2024.46,2484.2 2100.94,2484.38C2107.15,2484.39 2113.34,2484.61 2119.53,2485.03L2066.27,2547.24C2013.66,2553.12 1960.48,2576.29 1906.87,2617.68C1893.22,2628.22 1890.69,2647.86 1901.23,2661.51C1911.77,2675.16 1931.41,2677.69 1945.07,2667.15C1959.52,2655.99 1973.91,2646.39 1988.24,2638.39L1899.57,2741.95C1888.35,2755.06 1889.88,2774.8 1902.99,2786.02C1916.09,2797.23 1935.83,2795.7 1947.05,2782.6L2369,2289.75C2380.21,2276.65 2378.68,2256.91 2365.58,2245.69C2352.48,2234.47 2332.74,2236 2321.52,2249.1L2253.42,2328.65ZM2172.27,2558.76L2127.1,2611.52C2134.93,2612.95 2142.73,2614.91 2150.53,2617.39C2180.13,2626.81 2209.41,2643.42 2238.57,2666.8C2252.02,2677.58 2271.71,2675.42 2282.5,2661.96C2293.28,2648.51 2291.12,2628.82 2277.66,2618.03C2242.82,2590.1 2207.63,2570.41 2172.27,2558.76ZM2258.2,2458.39L2215.73,2508C2252.85,2523.18 2289.74,2545.64 2326.48,2575.09C2339.93,2585.88 2359.62,2583.71 2370.41,2570.26C2381.2,2556.8 2379.03,2537.12 2365.57,2526.33C2330,2497.81 2294.2,2475.18 2258.2,2458.39ZM2337.14,2366.18L2295.47,2414.86C2333.57,2434.38 2371.49,2459.36 2409.28,2489.66C2422.74,2500.45 2442.42,2498.28 2453.21,2484.82C2464,2471.37 2461.83,2451.68 2448.38,2440.89C2411.47,2411.31 2374.39,2386.41 2337.14,2366.18Z"/></g></svg></div><div class="offline-content"><h1>Check your connection</h1><p>You are offline. Please connect to the internet.</p></div><button class="offline-button" onclick="window.location.reload()">RETRY</button></div>';

    setTimeout(() => {
      document.querySelector('.offline-wrapper').style.transform = 'translateY(0)';
    }, 300);
  });
</script>
@endsection