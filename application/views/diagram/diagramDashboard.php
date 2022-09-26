<script>
    // Diagram General
    var ctx = document.getElementById('myChart').getContext('2d');
    var chart = new Chart(ctx, {
      // The type of chart we want to create
      type: 'bar', // also try bar or other graph types
      // The data for our dataset
      data: {
        labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"],
        // Information about the dataset
        datasets: [
          {
            label: "Kasus",
            backgroundColor: '#1C6758',
            borderColor: '#1C6758',
            data: [
              <?php
              foreach ($dataDiagram as $diagramGeneral => $item){
                echo $item['KSS'].",";
              }?>
            ],
          },
          {
            label: "Tersangka",
            backgroundColor: '#16213E',
            borderColor: '#16213E',
            data: [
              <?php
              foreach ($dataDiagram as $diagramGeneral => $item){
                echo $item['TSK'].",";
              }?>
            ],
          },
          {
            label: "SELRA",
            backgroundColor: '#FF1E00',
            borderColor: '#FF1E00',
            data: [
              <?php
              foreach ($dataDiagram as $diagramGeneral => $item){
                echo $item['SELRA'].",";
              }?>
            ],
          }
        ]
      },
      // Configuration options
      options: {
        layout: {
          padding: 2,
        },
        legend: {
          position: 'bottom',
        },
        title: {
          display: true,
          text: 'Diagram Tren Tindak Pidana Narkotika & Psikotropika <?= $this->session->userdata('login_data_admin')['nama'] ?> - <?= $tahunDiagram ?>'
        },
        scales: {
          yAxes: [{
            scaleLabel: {
              display: true,
              labelString: 'Jumlah'
            },
            ticks: {
                beginAtZero: true
            }
          }],
          xAxes: [{
            scaleLabel: {
              display: true,
              labelString: 'Bulan'
            }
          }]
        }
      }
    });

    // Diagram BB Ganja
    var ctxGanja = document.getElementById('GanjaChart').getContext('2d');
    var chartGanja = new Chart(ctxGanja, {
      type: 'bar',
      // The data for our dataset
      data: {
        labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"],
        datasets: [
          {
            label: "Ganja",
            backgroundColor: '#003366',
            borderColor: '#003366',
            data: [
              <?php 
                foreach ($dataDiagramBB as $diagramBB => $item) {
                  echo $item["Ganja"].",";
                }
              ?>
            ],
          },
      ]
      },
      options: {
        layout: {
          padding: 3,
        },
        legend: {
          position: 'bottom',
        },
        title: {
          display: true,
          text: 'Narkotika & Psikotropika || GANJA || <?= $this->session->userdata('login_data_admin')['nama'] ?> - <?= $tahunDiagram ?> '
        },
        scales: {
          yAxes: [{
            scaleLabel: {
              display: true,
              labelString: 'Jumlah (Gram)'
            },
            ticks: {
                beginAtZero: true
            }
          }],
          xAxes: [{
            scaleLabel: {
              display: true,
              labelString: 'Bulan'
            }
          }]
        }
      }
    });
    
    // Diagram BB Gorilla
    var ctxGorilla = document.getElementById('GorillaChart').getContext('2d');
    var chartGorilla = new Chart(ctxGorilla, {
      type: 'bar',
      // The data for our dataset
      data: {
        labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"],
        datasets: [
          {
            label: "Tembakau Gorrila",
            backgroundColor: '#336699',
            borderColor: '#336699',
            data: [
              <?php 
                foreach ($dataDiagramBB as $diagramBB => $item) {
                  echo $item["Tembakau Gorilla"].",";
                }
              ?>
            ],
          },
      ]
      },
      options: {
        layout: {
          padding: 3,
        },
        legend: {
          position: 'bottom',
        },
        title: {
          display: true,
          text: 'Narkotika & Psikotropika || TEMBAKAU GORILLA || <?= $this->session->userdata('login_data_admin')['nama'] ?> - <?= $tahunDiagram ?> '
        },
        scales: {
          yAxes: [{
            scaleLabel: {
              display: true,
              labelString: 'Jumlah (Gram)'
            },
            ticks: {
                beginAtZero: true
            }
          }],
          xAxes: [{
            scaleLabel: {
              display: true,
              labelString: 'Bulan'
            }
          }]
        }
      }
    });
    
    // Diagram BB Hashish
    var ctxHashish = document.getElementById('HashishChart').getContext('2d');
    var chartHashish = new Chart(ctxHashish, {
      type: 'bar',
      // The data for our dataset
      data: {
        labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"],
        datasets: [
          {
            label: "Hashish",
            backgroundColor: '#33ccff',
            borderColor: '#33ccff',
            data: [
              <?php 
                foreach ($dataDiagramBB as $diagramBB => $item) {
                  echo $item["Hashish"].",";
                }
              ?>
            ],
          },
      ]
      },
      options: {
        layout: {
          padding: 3,
        },
        legend: {
          position: 'bottom',
        },
        title: {
          display: true,
          text: 'Narkotika & Psikotropika || HASHISH || <?= $this->session->userdata('login_data_admin')['nama'] ?> - <?= $tahunDiagram ?> '
        },
        scales: {
          yAxes: [{
            scaleLabel: {
              display: true,
              labelString: 'Jumlah (Gram)'
            },
            ticks: {
                beginAtZero: true
            }
          }],
          xAxes: [{
            scaleLabel: {
              display: true,
              labelString: 'Bulan'
            }
          }]
        }
      }
    });
    
    // Diagram BB Opium
    var ctxOpium = document.getElementById('OpiumChart').getContext('2d');
    var chartOpium = new Chart(ctxOpium, {
      type: 'bar',
      // The data for our dataset
      data: {
        labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"],
        datasets: [
          {
            label: "Opium",
            backgroundColor: '#ccccff',
            borderColor: '#ccccff',
            data: [
              <?php 
                foreach ($dataDiagramBB as $diagramBB => $item) {
                  echo $item["Opium"].",";
                }
              ?>
            ],
          },
      ]
      },
      options: {
        layout: {
          padding: 3,
        },
        legend: {
          position: 'bottom',
        },
        title: {
          display: true,
          text: 'Narkotika & Psikotropika || OPIUM || <?= $this->session->userdata('login_data_admin')['nama'] ?> - <?= $tahunDiagram ?> '
        },
        scales: {
          yAxes: [{
            scaleLabel: {
              display: true,
              labelString: 'Jumlah (Gram)'
            },
            ticks: {
                beginAtZero: true
            }
          }],
          xAxes: [{
            scaleLabel: {
              display: true,
              labelString: 'Bulan'
            }
          }]
        }
      }
    });
    
    // Diagram BB Morphin
    var ctxMorphin = document.getElementById('MorphinChart').getContext('2d');
    var chartMorphin = new Chart(ctxMorphin, {
      type: 'bar',
      // The data for our dataset
      data: {
        labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"],
        datasets: [
          {
            label: "Morphin",
            backgroundColor: '#66ff99',
            borderColor: '#66ff99',
            data: [
              <?php 
                foreach ($dataDiagramBB as $diagramBB => $item) {
                  echo $item["Morphin"].",";
                }
              ?>
            ],
          },
      ]
      },
      options: {
        layout: {
          padding: 3,
        },
        legend: {
          position: 'bottom',
        },
        title: {
          display: true,
          text: 'Narkotika & Psikotropika || MORPHIN || <?= $this->session->userdata('login_data_admin')['nama'] ?> - <?= $tahunDiagram ?> '
        },
        scales: {
          yAxes: [{
            scaleLabel: {
              display: true,
              labelString: 'Jumlah (Gram)'
            },
            ticks: {
                beginAtZero: true
            }
          }],
          xAxes: [{
            scaleLabel: {
              display: true,
              labelString: 'Bulan'
            }
          }]
        }
      }
    });
    
    // Diagram BB Heroin
    var ctxHeroin = document.getElementById('HeroinChart').getContext('2d');
    var chartHeroin = new Chart(ctxHeroin, {
      type: 'bar',
      // The data for our dataset
      data: {
        labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"],
        datasets: [
          {
            label: "Heroin/Putaw",
            backgroundColor: '#006600',
            borderColor: '#006600',
            data: [
              <?php 
                foreach ($dataDiagramBB as $diagramBB => $item) {
                  echo $item["Heroin/Putaw"].",";
                }
              ?>
            ],
          },
      ]
      },
      options: {
        layout: {
          padding: 3,
        },
        legend: {
          position: 'bottom',
        },
        title: {
          display: true,
          text: 'Narkotika & Psikotropika || HEROIN / PUTAW || <?= $this->session->userdata('login_data_admin')['nama'] ?> - <?= $tahunDiagram ?> '
        },
        scales: {
          yAxes: [{
            scaleLabel: {
              display: true,
              labelString: 'Jumlah (Gram)'
            },
            ticks: {
                beginAtZero: true
            }
          }],
          xAxes: [{
            scaleLabel: {
              display: true,
              labelString: 'Bulan'
            }
          }]
        }
      }
    });
    
    // Diagram BB Kokain
    var ctxKokain = document.getElementById('KokainChart').getContext('2d');
    var chartKokain = new Chart(ctxKokain, {
      type: 'bar',
      // The data for our dataset
      data: {
        labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"],
        datasets: [
          {
            label: "Kokain",
            backgroundColor: '#669900',
            borderColor: '#669900',
            data: [
              <?php 
                foreach ($dataDiagramBB as $diagramBB => $item) {
                  echo $item["Kokain"].",";
                }
              ?>
            ],
          },
      ]
      },
      options: {
        layout: {
          padding: 3,
        },
        legend: {
          position: 'bottom',
        },
        title: {
          display: true,
          text: 'Narkotika & Psikotropika || KOKAIN || <?= $this->session->userdata('login_data_admin')['nama'] ?> - <?= $tahunDiagram ?> '
        },
        scales: {
          yAxes: [{
            scaleLabel: {
              display: true,
              labelString: 'Jumlah (Gram)'
            },
            ticks: {
                beginAtZero: true
            }
          }],
          xAxes: [{
            scaleLabel: {
              display: true,
              labelString: 'Bulan'
            }
          }]
        }
      }
    });
    
    // Diagram BB Exstacy
    var ctxExstacy = document.getElementById('ExstacyChart').getContext('2d');
    var chartExstacy = new Chart(ctxExstacy, {
      type: 'bar',
      // The data for our dataset
      data: {
        labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"],
        datasets: [
          {
            label: "Exstacy/Carnophen",
            backgroundColor: '#cc9900',
            borderColor: '#cc9900',
            data: [
              <?php 
                foreach ($dataDiagramBB as $diagramBB => $item) {
                  echo $item["Exstacy/Carnophen"].",";
                }
              ?>
            ],
          },
      ]
      },
      options: {
        layout: {
          padding: 3,
        },
        legend: {
          position: 'bottom',
        },
        title: {
          display: true,
          text: 'Narkotika & Psikotropika || EXSTACY / CARNOPHEN || <?= $this->session->userdata('login_data_admin')['nama'] ?> - <?= $tahunDiagram ?> '
        },
        scales: {
          yAxes: [{
            scaleLabel: {
              display: true,
              labelString: 'Jumlah (Butir)'
            },
            ticks: {
                beginAtZero: true
            }
          }],
          xAxes: [{
            scaleLabel: {
              display: true,
              labelString: 'Bulan'
            }
          }]
        }
      }
    });
    
    // Diagram BB Sabu
    var ctxSabu = document.getElementById('SabuChart').getContext('2d');
    var chartSabu = new Chart(ctxSabu, {
      type: 'bar',
      // The data for our dataset
      data: {
        labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"],
        datasets: [
          {
            label: "Sabu",
            backgroundColor: '#ff3300',
            borderColor: '#ff3300',
            data: [
              <?php 
                foreach ($dataDiagramBB as $diagramBB => $item) {
                  echo $item["Sabu"].",";
                }
              ?>
            ],
          },
      ]
      },
      options: {
        layout: {
          padding: 3,
        },
        legend: {
          position: 'bottom',
        },
        title: {
          display: true,
          text: 'Narkotika & Psikotropika || SABU || <?= $this->session->userdata('login_data_admin')['nama'] ?> - <?= $tahunDiagram ?> '
        },
        scales: {
          yAxes: [{
            scaleLabel: {
              display: true,
              labelString: 'Jumlah (Gram)'
            },
            ticks: {
                beginAtZero: true
            }
          }],
          xAxes: [{
            scaleLabel: {
              display: true,
              labelString: 'Bulan'
            }
          }]
        }
      }
    });
    
    // Diagram BB GOL IV
    var ctxGol = document.getElementById('GolChart').getContext('2d');
    var chartGol = new Chart(ctxGol, {
      type: 'bar',
      // The data for our dataset
      data: {
        labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"],
        datasets: [
          {
            label: "GOL IV",
            backgroundColor: '#990033',
            borderColor: '#990033',
            data: [
              <?php 
                foreach ($dataDiagramBB as $diagramBB => $item) {
                  echo $item["GOL IV"].",";
                }
              ?>
            ],
          },
      ]
      },
      options: {
        layout: {
          padding: 3,
        },
        legend: {
          position: 'bottom',
        },
        title: {
          display: true,
          text: 'Narkotika & Psikotropika || GOL IV || <?= $this->session->userdata('login_data_admin')['nama'] ?> - <?= $tahunDiagram ?> '
        },
        scales: {
          yAxes: [{
            scaleLabel: {
              display: true,
              labelString: 'Jumlah (Butir)'
            },
            ticks: {
                beginAtZero: true
            }
          }],
          xAxes: [{
            scaleLabel: {
              display: true,
              labelString: 'Bulan'
            }
          }]
        }
      }
    });
    
    // Diagram BB Daftar G
    var ctxDaftar = document.getElementById('DaftarChart').getContext('2d');
    var chartDaftar = new Chart(ctxDaftar, {
      type: 'bar',
      // The data for our dataset
      data: {
        labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"],
        datasets: [
          {
            label: "Daftar G",
            backgroundColor: '#990099',
            borderColor: '#990099',
            data: [
              <?php 
                foreach ($dataDiagramBB as $diagramBB => $item) {
                  echo $item["Daftar G"].",";
                }
              ?>
            ],
          },
      ]
      },
      options: {
        layout: {
          padding: 3,
        },
        legend: {
          position: 'bottom',
        },
        title: {
          display: true,
          text: 'Narkotika & Psikotropika || DAFTAR G || <?= $this->session->userdata('login_data_admin')['nama'] ?> - <?= $tahunDiagram ?> '
        },
        scales: {
          yAxes: [{
            scaleLabel: {
              display: true,
              labelString: 'Jumlah (Butir)'
            },
            ticks: {
                beginAtZero: true
            }
          }],
          xAxes: [{
            scaleLabel: {
              display: true,
              labelString: 'Bulan'
            }
          }]
        }
      }
    });
    
    // Diagram BB Kosmetik
    var ctxKosmetik = document.getElementById('KosmetikChart').getContext('2d');
    var chartKosmetik = new Chart(ctxKosmetik, {
      type: 'bar',
      // The data for our dataset
      data: {
        labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"],
        datasets: [
          {
            label: "Kosmetik",
            backgroundColor: '#9900ff',
            borderColor: '#9900ff',
            data: [
              <?php 
                foreach ($dataDiagramBB as $diagramBB => $item) {
                  echo $item["Kosmetik"].",";
                }
              ?>
            ],
          },
      ]
      },
      options: {
        layout: {
          padding: 3,
        },
        legend: {
          position: 'bottom',
        },
        title: {
          display: true,
          text: 'Narkotika & Psikotropika || KOSMETIK || <?= $this->session->userdata('login_data_admin')['nama'] ?> - <?= $tahunDiagram ?> '
        },
        scales: {
          yAxes: [{
            scaleLabel: {
              display: true,
              labelString: 'Jumlah (Buah)'
            },
            ticks: {
                beginAtZero: true
            }
          }],
          xAxes: [{
            scaleLabel: {
              display: true,
              labelString: 'Bulan'
            }
          }]
        }
      }
    });
    
    // Diagram BB Jamu
    var ctxJamu = document.getElementById('JamuChart').getContext('2d');
    var chartJamu = new Chart(ctxJamu, {
      type: 'bar',
      // The data for our dataset
      data: {
        labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"],
        datasets: [
          {
            label: "Jamu",
            backgroundColor: '#666699',
            borderColor: '#666699',
            data: [
              <?php 
                foreach ($dataDiagramBB as $diagramBB => $item) {
                  echo $item["Jamu"].",";
                }
              ?>
            ],
          },
      ]
      },
      options: {
        layout: {
          padding: 3,
        },
        legend: {
          position: 'bottom',
        },
        title: {
          display: true,
          text: 'Narkotika & Psikotropika || JAMU || <?= $this->session->userdata('login_data_admin')['nama'] ?> - <?= $tahunDiagram ?> '
        },
        scales: {
          yAxes: [{
            scaleLabel: {
              display: true,
              labelString: 'Jumlah (Buah)'
            },
            ticks: {
                beginAtZero: true
            }
          }],
          xAxes: [{
            scaleLabel: {
              display: true,
              labelString: 'Bulan'
            }
          }]
        }
      }
    });
    

</script>