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
        maintainAspectRatio: false,
        layout: {
          padding: 1
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
        maintainAspectRatio: false,
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
        maintainAspectRatio: false,
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
        maintainAspectRatio: false,
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
        maintainAspectRatio: false,
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
        maintainAspectRatio: false,
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
        maintainAspectRatio: false,
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
        maintainAspectRatio: false,
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
        maintainAspectRatio: false,
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
        maintainAspectRatio: false,
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
    
    // Diagram BB GOL IV (Gram & Butir)
    var ctxGol = document.getElementById('GolIVGram').getContext('2d');
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
                foreach ($dataDiagramBBGol as $diagramBBGol => $itemGol) {
                  echo $itemGol["GOL IV"]['Gram'].",";
                }
              ?>
            ],
          },
      ]
      },
      options: {
        maintainAspectRatio: false,
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

    var ctxGol = document.getElementById('GolIVButir').getContext('2d');
    var chartGol = new Chart(ctxGol, {
      type: 'bar',
      // The data for our dataset
      data: {
        labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"],
        datasets: [
          {
            label: "GOL IV",
            backgroundColor: '#780099',
            borderColor: '#780099',
            data: [
              <?php 
                foreach ($dataDiagramBBGol as $diagramBBGol => $itemGol) {
                  echo $itemGol["GOL IV"]['Butir'].",";
                }
              ?>
            ],
          },
      ]
      },
      options: {
        maintainAspectRatio: false,
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
    
    // Diagram BB GOL III (Gram & Butir)
    var ctxGol = document.getElementById('GolIIIGram').getContext('2d');
    var chartGol = new Chart(ctxGol, {
      type: 'bar',
      // The data for our dataset
      data: {
        labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"],
        datasets: [
          {
            label: "GOL III",
            backgroundColor: '#005e99',
            borderColor: '#005e99',
            data: [
              <?php 
                foreach ($dataDiagramBBGol as $diagramBBGol => $itemGol) {
                  echo $itemGol["GOL III"]['Gram'].",";
                }
              ?>
            ],
          },
      ]
      },
      options: {
        maintainAspectRatio: false,
        layout: {
          padding: 3,
        },
        legend: {
          position: 'bottom',
        },
        title: {
          display: true,
          text: 'Narkotika & Psikotropika || GOL III || <?= $this->session->userdata('login_data_admin')['nama'] ?> - <?= $tahunDiagram ?> '
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

    var ctxGol = document.getElementById('GolIIIButir').getContext('2d');
    var chartGol = new Chart(ctxGol, {
      type: 'bar',
      // The data for our dataset
      data: {
        labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"],
        datasets: [
          {
            label: "GOL III",
            backgroundColor: '#009994',
            borderColor: '#009994',
            data: [
              <?php 
                foreach ($dataDiagramBBGol as $diagramBBGol => $itemGol) {
                  echo $itemGol["GOL III"]['Butir'].",";
                }
              ?>
            ],
          },
      ]
      },
      options: {
        maintainAspectRatio: false,
        layout: {
          padding: 3,
        },
        legend: {
          position: 'bottom',
        },
        title: {
          display: true,
          text: 'Narkotika & Psikotropika || GOL III || <?= $this->session->userdata('login_data_admin')['nama'] ?> - <?= $tahunDiagram ?> '
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
        maintainAspectRatio: false,
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
        maintainAspectRatio: false,
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
        maintainAspectRatio: false,
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