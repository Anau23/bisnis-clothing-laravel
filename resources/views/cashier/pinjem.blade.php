{{-- 
|--------------------------------------------------------------------------
| Cashier Page - Pinjem
|--------------------------------------------------------------------------
| NOTE:
| - File ini adalah hasil konversi HTML ke Blade
| - TIDAK ADA perubahan isi
| - Semua CSS & JS tetap inline
| - Aman dipakai via Laravel view()
|--------------------------------------------------------------------------
--}}

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>HAFIIDH • Full Stack Developer & Digital Creator</title>
  <meta name="description" content="Transforming visions into extraordinary digital experiences through code and design">
  <!-- Open Graph Meta Tags -->
  <meta property="og:title" content="HAFIIDH • Full Stack Developer & Digital Creator">
  <meta property="og:description" content="Crafting next-generation digital experiences">
  <meta property="og:image" content="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80">
  <meta property="og:url" content="https://hafiidh.dev">
  <!-- Favicon -->
  <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>⚡</text></svg>">

  <!-- Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/three@0.132.2/build/three.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/three@0.132.2/examples/js/controls/OrbitControls.js"></script>
  <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
  <script src="https://unpkg.com/feather-icons"></script>
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Custom Config -->
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            'sans': ['SF Pro Display', 'Inter', 'system-ui', 'sans-serif'],
            'display': ['Clash Grotesk', 'Clash Display', 'sans-serif'],
            'mono': ['JetBrains Mono', 'monospace'],
            'serif': ['Playfair Display', 'serif']
          },
          colors: {
            'tech': {
              'dark': '#0a0a0f',
              'darker': '#050508',
              'blue': '#0066ff',
              'cyan': '#00f3ff',
              'purple': '#8a2be2',
              'teal': '#20d9d2',
              'pink': '#ff2d95',
              'green': '#00ff88',
              'yellow': '#ffd700',
              'orange': '#ff6b35',
              'red': '#ff375f'
            },
            'glass': {
              'light': 'rgba(255, 255, 255, 0.05)',
              'medium': 'rgba(255, 255, 255, 0.03)',
              'dark': 'rgba(0, 0, 0, 0.25)'
            }
          },
          animation: {
            'float': 'float 6s ease-in-out infinite',
            'float-3d': 'float3d 8s ease-in-out infinite',
            'pulse-glow': 'pulse-glow 2s ease-in-out infinite',
            'slide-up': 'slide-up 0.8s cubic-bezier(0.16, 1, 0.3, 1)',
            'fade-in': 'fade-in 1s ease-out',
            'typing': 'typing 3.5s steps(40, end)',
            'blink-caret': 'blink-caret .75s step-end infinite',
            'spin-slow': 'spin 20s linear infinite',
            'bounce-slow': 'bounce 3s infinite',
            'circuit-flow': 'circuitFlow 20s linear infinite',
            'data-stream': 'dataStream 15s linear infinite',
            'grid-move': 'gridMove 30s linear infinite',
            'hologram-scan': 'hologramScan 3s linear infinite',
            'particle-float': 'particleFloat 20s linear infinite',
            'wave': 'wave 10s ease-in-out infinite',
            'ripple': 'ripple 2s linear infinite',
            'orbit': 'orbit 15s linear infinite',
            'morph': 'morph 8s ease-in-out infinite',
            'shimmer': 'shimmer 2s infinite',
            'breath': 'breath 6s ease-in-out infinite',
            'connect-dots': 'connectDots 4s linear infinite',
            'wireframe-glow': 'wireframeGlow 3s ease-in-out infinite',
            'tech-grid': 'techGrid 20s linear infinite',
            'blueprint-fade': 'blueprintFade 5s ease-in-out infinite',
            'matrix-fall': 'matrixFall 25s linear infinite',
            'cyber-rain': 'cyberRain 20s linear infinite',
            'neural-network': 'neuralNetwork 30s linear infinite',
            'quantum-dots': 'quantumDots 15s ease-in-out infinite',
            'data-pulse': 'dataPulse 8s ease-in-out infinite',
            'circuit-glow': 'circuitGlow 4s ease-in-out infinite',
            'hologram-grid': 'hologramGrid 40s linear infinite',
            'particle-trail': 'particleTrail 10s linear infinite',
            'tech-orbit': 'techOrbit 25s linear infinite',
            'binary-flow': 'binaryFlow 35s linear infinite',
            'nebula-swirl': 'nebulaSwirl 60s linear infinite',
            'energy-wave': 'energyWave 8s ease-in-out infinite',
            'digital-rain': 'digitalRain 20s linear infinite',
            'code-matrix': 'codeMatrix 40s linear infinite',
            'circuit-scan': 'circuitScan 10s linear infinite',
            'particle-swarm': 'particleSwarm 25s linear infinite',
            'cursor-trail': 'cursorTrail 0.5s linear forwards',
            'cursor-sparkle': 'cursorSparkle 0.3s ease-out forwards',
            'cursor-ring-pulse': 'cursorRingPulse 2s ease-in-out infinite',
            'cursor-magnetic': 'cursorMagnetic 0.3s ease-out',
            'cursor-hover-scale': 'cursorHoverScale 0.3s ease-out',
            'cursor-trail-dots': 'cursorTrailDots 1s linear infinite',
            'cursor-ripple': 'cursorRipple 0.6s ease-out forwards',
            'github-wave': 'githubWave 2s ease-in-out infinite'
          },
          keyframes: {
            'float': {
              '0%, 100%': { transform: 'translateY(0px)' },
              '50%': { transform: 'translateY(-20px)' }
            },
            'float3d': {
              '0%, 100%': { transform: 'translateY(0px) rotateX(0deg) rotateY(0deg)' },
              '33%': { transform: 'translateY(-20px) rotateX(5deg) rotateY(5deg)' },
              '66%': { transform: 'translateY(-10px) rotateX(-5deg) rotateY(-5deg)' }
            },
            'cursor-trail': {
              '0%': { opacity: '1', transform: 'translate(-50%, -50%) scale(1)' },
              '100%': { opacity: '0', transform: 'translate(-50%, -50%) scale(0)' }
            },
            'cursor-sparkle': {
              '0%': { opacity: '1', transform: 'scale(0) rotate(0deg)' },
              '100%': { opacity: '0', transform: 'scale(1) rotate(360deg)' }
            },
            'cursor-ring-pulse': {
              '0%, 100%': { transform: 'scale(1)', opacity: '0.5' },
              '50%': { transform: 'scale(1.2)', opacity: '0.8' }
            },
            'cursor-magnetic': {
              '0%': { transform: 'translate(-50%, -50%) scale(1)' },
              '100%': { transform: 'translate(-50%, -50%) scale(1.5)' }
            },
            'cursor-hover-scale': {
              '0%': { transform: 'translate(-50%, -50%) scale(1)' },
              '100%': { transform: 'translate(-50%, -50%) scale(1.8)' }
            },
            'cursor-trail-dots': {
              '0%': { opacity: '1', transform: 'translate(-50%, -50%) scale(1)' },
              '100%': { opacity: '0', transform: 'translate(-50%, -50%) scale(0.5) translateY(-20px)' }
            },
            'cursor-ripple': {
              '0%': { opacity: '1', transform: 'scale(0)' },
              '100%': { opacity: '0', transform: 'scale(4)' }
            },
            'githubWave': {
              '0%, 100%': { transform: 'translateY(0)' },
              '50%': { transform: 'translateY(-10px)' }
            },
            'circuitFlow': {
              '0%': { 'stroke-dashoffset': '1000' },
              '100%': { 'stroke-dashoffset': '0' }
            },
            'dataStream': {
              '0%': { transform: 'translateY(-100%)' },
              '100%': { transform: 'translateY(100%)' }
            },
            'gridMove': {
              '0%': { transform: 'translate(0, 0)' },
              '100%': { transform: 'translate(-100px, -100px)' }
            },
            'hologramScan': {
              '0%': { transform: 'translateY(-100%)' },
              '100%': { transform: 'translateY(100vh)' }
            },
            'particleFloat': {
              '0%, 100%': { transform: 'translate(0, 0) rotate(0deg)' },
              '33%': { transform: 'translate(30px, -20px) rotate(120deg)' },
              '66%': { transform: 'translate(-20px, 15px) rotate(240deg)' }
            },
            'wave': {
              '0%, 100%': { transform: 'translateY(0) scaleY(1)' },
              '50%': { transform: 'translateY(-20px) scaleY(1.1)' }
            },
            'ripple': {
              '0%': { transform: 'scale(0.8)', opacity: '1' },
              '100%': { transform: 'scale(2)', opacity: '0' }
            },
            'orbit': {
              '0%': { transform: 'rotate(0deg) translateX(150px) rotate(0deg)' },
              '100%': { transform: 'rotate(360deg) translateX(150px) rotate(-360deg)' }
            },
            'morph': {
              '0%, 100%': { 'border-radius': '60% 40% 30% 70% / 60% 30% 70% 40%' },
              '50%': { 'border-radius': '30% 60% 70% 40% / 50% 60% 30% 60%' }
            },
            'shimmer': {
              '0%': { 'background-position': '-1000px 0' },
              '100%': { 'background-position': '1000px 0' }
            },
            'breath': {
              '0%, 100%': { opacity: '0.3' },
              '50%': { opacity: '0.8' }
            },
            'connectDots': {
              '0%': { 'stroke-dashoffset': '100' },
              '100%': { 'stroke-dashoffset': '0' }
            },
            'wireframeGlow': {
              '0%, 100%': { opacity: '0.1' },
              '50%': { opacity: '0.3' }
            },
            'techGrid': {
              '0%': { transform: 'translate(0, 0)' },
              '100%': { transform: 'translate(-200px, -200px)' }
            },
            'blueprintFade': {
              '0%, 100%': { opacity: '0.05' },
              '50%': { opacity: '0.1' }
            },
            'matrixFall': {
              '0%': { transform: 'translateY(-100%)' },
              '100%': { transform: 'translateY(100vh)' }
            },
            'cyberRain': {
              '0%': { transform: 'translateY(-100%) rotate(0deg)' },
              '100%': { transform: 'translateY(100vh) rotate(360deg)' }
            },
            'neuralNetwork': {
              '0%': { 'stroke-dashoffset': '500' },
              '100%': { 'stroke-dashoffset': '0' }
            },
            'quantumDots': {
              '0%, 100%': { transform: 'scale(1)', opacity: '0.3' },
              '50%': { transform: 'scale(1.2)', opacity: '0.6' }
            },
            'dataPulse': {
              '0%, 100%': { transform: 'scale(1)', opacity: '0.1' },
              '50%': { transform: 'scale(1.5)', opacity: '0.3' }
            },
            'circuitGlow': {
              '0%, 100%': { filter: 'brightness(1) drop-shadow(0 0 5px rgba(0, 102, 255, 0.3))' },
              '50%': { filter: 'brightness(1.5) drop-shadow(0 0 20px rgba(0, 102, 255, 0.6))' }
            },
            'hologramGrid': {
              '0%': { transform: 'translate(0, 0)' },
              '100%': { transform: 'translate(-400px, -400px)' }
            },
            'particleTrail': {
              '0%': { transform: 'translateY(-100%) translateX(-50px)' },
              '100%': { transform: 'translateY(100vh) translateX(50px)' }
            },
            'techOrbit': {
              '0%': { transform: 'rotate(0deg) translateX(200px) rotate(0deg)' },
              '100%': { transform: 'rotate(360deg) translateX(200px) rotate(-360deg)' }
            },
            'binaryFlow': {
              '0%': { transform: 'translateX(-100%)' },
              '100%': { transform: 'translateX(100%)' }
            },
            'nebulaSwirl': {
              '0%': { transform: 'rotate(0deg) scale(1)' },
              '50%': { transform: 'rotate(180deg) scale(1.2)' },
              '100%': { transform: 'rotate(360deg) scale(1)' }
            },
            'energyWave': {
              '0%, 100%': { transform: 'translateX(-100%)' },
              '50%': { transform: 'translateX(0%)' }
            },
            'digitalRain': {
              '0%': { transform: 'translateY(-100%)' },
              '100%': { transform: 'translateY(100vh)' }
            },
            'codeMatrix': {
              '0%': { opacity: '0.1' },
              '50%': { opacity: '0.3' },
              '100%': { opacity: '0.1' }
            },
            'circuitScan': {
              '0%': { transform: 'translateX(-100%)' },
              '100%': { transform: 'translateX(100%)' }
            },
            'particleSwarm': {
              '0%, 100%': { transform: 'translate(0, 0)' },
              '25%': { transform: 'translate(20px, -20px)' },
              '50%': { transform: 'translate(-10px, 10px)' },
              '75%': { transform: 'translate(15px, 5px)' }
            },
            'pulse-glow': {
              '0%, 100%': { 
                'box-shadow': '0 0 20px rgba(0, 102, 255, 0.3)',
                'transform': 'scale(1)'
              },
              '50%': { 
                'box-shadow': '0 0 40px rgba(0, 102, 255, 0.6)',
                'transform': 'scale(1.02)'
              }
            },
            'slide-up': {
              '0%': { transform: 'translateY(100px)', opacity: '0' },
              '100%': { transform: 'translateY(0)', opacity: '1' }
            },
            'fade-in': {
              '0%': { opacity: '0' },
              '100%': { opacity: '1' }
            },
            'typing': {
              'from': { width: '0' },
              'to': { width: '100%' }
            },
            'blink-caret': {
              'from, to': { 'border-color': 'transparent' },
              '50%': { 'border-color': '#0066ff' }
            }
          },
          backgroundImage: {
            'gradient-radial': 'radial-gradient(var(--tw-gradient-stops))',
            'gradient-conic': 'conic-gradient(from 180deg at 50% 50%, var(--tw-gradient-stops))',
            'circuit': "url('data:image/svg+xml,%3Csvg width=%22100%25%22 height=%22100%25%22 viewBox=%220 0 100 100%22 xmlns=%22http://www.w3.org/2000/svg%22%3E%3Cdefs%3E%3Cpattern id=%22circuit%22 width=%2250%22 height=%2250%22 patternUnits=%22userSpaceOnUse%22%3E%3Cpath d=%22M0 0h50v50H0z%22 fill=%22none%22/%3E%3Cpath d=%22M25 0v25M0 25h25M25 50v-25M50 25H25%22 stroke=%22%230066ff%22 stroke-width=%220.5%22 opacity=%220.1%22/%3E%3Ccircle cx=%2225%22 cy=%2225%22 r=%222%22 fill=%22%230066ff%22 opacity=%220.1%22/%3E%3C/pattern%3E%3C/defs%3E%3Crect width=%22100%25%22 height=%22100%25%22 fill=%22url(%23circuit)%22/%3E%3C/svg%3E')",
            'blueprint': "url('data:image/svg+xml,%3Csvg width=%22100%25%22 height=%22100%25%22 viewBox=%220 0 100 100%22 xmlns=%22http://www.w3.org/2000/svg%22%3E%3Cdefs%3E%3Cpattern id=%22blueprint%22 width=%2240%22 height=%2240%22 patternUnits=%22userSpaceOnUse%22%3E%3Cpath d=%22M0 0h40v40H0z%22 fill=%22none%22 stroke=%22%2300f3ff%22 stroke-width=%220.3%22 opacity=%220.05%22/%3E%3Cpath d=%22M20 0v40M0 20h40%22 stroke=%22%2300f3ff%22 stroke-width=%220.2%22 opacity=%220.05%22/%3E%3C/pattern%3E%3C/defs%3E%3Crect width=%22100%25%22 height=%22100%25%22 fill=%22url(%23blueprint)%22/%3E%3C/svg%3E')"
          }
        }
      }
    }
  </script>
  
  <!-- Google Fonts & FontShare -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet">
  <link href="https://api.fontshare.com/v2/css?f[]=clash-grotesk@400,500,600,700&f[]=satoshi@400,500,700&display=swap" rel="stylesheet">
  
  <!-- Custom Styles -->
  <style>
    @import url('https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@300;400;500&display=swap');
    
    :root {
      --tech-dark: #0a0a0f;
      --tech-darker: #050508;
      --tech-blue: #0066ff;
      --tech-cyan: #00f3ff;
      --tech-purple: #8a2be2;
      --tech-teal: #20d9d2;
      --tech-pink: #ff2d95;
      --tech-green: #00ff88;
      --tech-yellow: #ffd700;
      --tech-orange: #ff6b35;
      --tech-red: #ff375f;
      --tech-gray-200: #e5e5e5;
      --tech-gray-800: #262626;
    }
    
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    
    html {
      scroll-behavior: smooth;
      scroll-padding-top: 100px;
    }
    
    body {
      font-family: 'Inter', sans-serif;
      background: var(--tech-dark);
      color: var(--tech-gray-200);
      overflow-x: hidden;
      cursor: none !important;
    }
    
    /* Advanced Cursor System */
    .cursor-dot {
      width: 6px;
      height: 6px;
      background: var(--tech-cyan);
      border-radius: 50%;
      position: fixed;
      pointer-events: none;
      z-index: 99999;
      transition: transform 0.1s ease;
      box-shadow: 0 0 10px var(--tech-cyan), 0 0 20px var(--tech-cyan);
      mix-blend-mode: difference;
    }
    
    .cursor-ring {
      width: 30px;
      height: 30px;
      border: 2px solid var(--tech-blue);
      border-radius: 50%;
      position: fixed;
      pointer-events: none;
      z-index: 99998;
      transition: all 0.2s ease;
      opacity: 0.7;
      mix-blend-mode: difference;
      animation: cursor-ring-pulse 2s ease-in-out infinite;
    }
    
    .cursor-trail {
      position: fixed;
      width: 8px;
      height: 8px;
      background: linear-gradient(45deg, var(--tech-cyan), var(--tech-blue));
      border-radius: 50%;
      pointer-events: none;
      z-index: 99997;
      opacity: 0.7;
      filter: blur(1px);
      mix-blend-mode: difference;
    }
    
    .cursor-sparkle {
      position: fixed;
      width: 4px;
      height: 4px;
      background: var(--tech-yellow);
      border-radius: 50%;
      pointer-events: none;
      z-index: 99996;
      box-shadow: 0 0 10px var(--tech-yellow);
      mix-blend-mode: difference;
    }
    
    .cursor-magnetic-effect {
      position: fixed;
      width: 60px;
      height: 60px;
      border: 1px solid var(--tech-purple);
      border-radius: 50%;
      pointer-events: none;
      z-index: 99995;
      opacity: 0;
      transition: opacity 0.3s ease;
      mix-blend-mode: difference;
    }
    
    .cursor-ripple {
      position: fixed;
      border: 2px solid var(--tech-cyan);
      border-radius: 50%;
      pointer-events: none;
      z-index: 99994;
      opacity: 0;
      mix-blend-mode: difference;
    }
    
    /* Ultra Advanced Background Container */
    #tech-universe {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: -20;
      overflow: hidden;
      perspective: 1000px;
    }
    
    /* Quantum Grid System */
    .quantum-grid {
      position: absolute;
      width: 100%;
      height: 100%;
      background-image: 
        linear-gradient(90deg, transparent 99%, rgba(0, 102, 255, 0.03) 100%),
        linear-gradient(0deg, transparent 99%, rgba(0, 102, 255, 0.03) 100%);
      background-size: 60px 60px;
      animation: hologramGrid 40s linear infinite;
      opacity: 0.2;
    }
    
    /* Nebula Swirl Effect */
    .nebula-swirl {
      position: absolute;
      width: 100%;
      height: 100%;
      background: 
        radial-gradient(circle at 20% 50%, rgba(0, 102, 255, 0.15) 0%, transparent 50%),
        radial-gradient(circle at 80% 20%, rgba(0, 243, 255, 0.15) 0%, transparent 50%),
        radial-gradient(circle at 40% 80%, rgba(138, 43, 226, 0.15) 0%, transparent 50%);
      filter: blur(60px);
      animation: nebulaSwirl 60s linear infinite;
    }
    
    /* Neural Network Connections */
    .neural-network {
      position: absolute;
      width: 100%;
      height: 100%;
      pointer-events: none;
    }
    
    .neural-node {
      position: absolute;
      width: 4px;
      height: 4px;
      background: var(--tech-cyan);
      border-radius: 50%;
      opacity: 0.15;
      animation: quantumDots 15s ease-in-out infinite;
    }
    
    .neural-connection {
      position: absolute;
      height: 1px;
      background: linear-gradient(90deg, transparent, var(--tech-blue), transparent);
      opacity: 0.08;
      transform-origin: left center;
      animation: connectDots 4s linear infinite;
    }
    
    /* Holographic Data Streams */
    .holographic-stream {
      position: absolute;
      width: 1px;
      height: 200px;
      background: linear-gradient(to bottom, 
        transparent,
        var(--tech-cyan),
        var(--tech-blue),
        transparent);
      filter: blur(0.5px);
      opacity: 0.15;
      animation: dataStream 15s linear infinite;
    }
    
    /* Cyber Rain Effect */
    .cyber-rain {
      position: absolute;
      width: 1px;
      height: 40px;
      background: linear-gradient(to bottom, transparent, var(--tech-purple), transparent);
      opacity: 0.1;
      animation: cyberRain 20s linear infinite;
    }
    
    /* Quantum Particle Field */
    .quantum-particle {
      position: absolute;
      width: 2px;
      height: 2px;
      background: var(--tech-cyan);
      border-radius: 50%;
      opacity: 0.1;
      animation: particleTrail 10s linear infinite;
    }
    
    /* Digital Rain (Matrix) */
    .digital-rain {
      position: absolute;
      font-family: 'JetBrains Mono', monospace;
      font-size: 14px;
      color: var(--tech-cyan);
      opacity: 0.05;
      animation: digitalRain 20s linear infinite;
      text-shadow: 0 0 5px var(--tech-cyan);
    }
    
    /* Energy Wave */
    .energy-wave {
      position: absolute;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, 
        transparent 0%,
        rgba(0, 102, 255, 0.1) 20%,
        rgba(0, 243, 255, 0.1) 40%,
        rgba(138, 43, 226, 0.1) 60%,
        transparent 100%);
      opacity: 0.1;
      animation: energyWave 8s ease-in-out infinite;
    }
    
    /* Circuit Scan Line */
    .circuit-scan {
      position: absolute;
      width: 100%;
      height: 2px;
      background: linear-gradient(90deg, transparent, var(--tech-cyan), transparent);
      filter: blur(1px);
      opacity: 0.1;
      animation: circuitScan 10s linear infinite;
    }
    
    /* Particle Swarm */
    .particle-swarm {
      position: absolute;
      width: 3px;
      height: 3px;
      background: var(--tech-cyan);
      border-radius: 50%;
      opacity: 0.1;
      animation: particleSwarm 25s ease-in-out infinite;
    }
    
    /* Code Matrix Grid */
    .code-matrix {
      position: absolute;
      width: 100%;
      height: 100%;
      background-image: 
        linear-gradient(90deg, rgba(0, 243, 255, 0.05) 1px, transparent 1px),
        linear-gradient(0deg, rgba(0, 243, 255, 0.05) 1px, transparent 1px);
      background-size: 50px 50px;
      animation: codeMatrix 40s linear infinite;
    }
    
    /* Glass Effects */
    .glass {
      background: rgba(255, 255, 255, 0.02);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      border: 1px solid rgba(255, 255, 255, 0.05);
    }
    
    .glass-heavy {
      background: rgba(10, 10, 15, 0.8);
      backdrop-filter: blur(40px);
      -webkit-backdrop-filter: blur(40px);
      border: 1px solid rgba(255, 255, 255, 0.03);
    }
    
    /* Advanced Gradient Text */
    .gradient-text {
      background: linear-gradient(135deg, 
        var(--tech-blue), 
        var(--tech-cyan), 
        var(--tech-purple),
        var(--tech-teal),
        var(--tech-blue));
      background-size: 300% 300%;
      -webkit-background-clip: text;
      background-clip: text;
      -webkit-text-fill-color: transparent;
      animation: text-gradient 6s ease infinite;
    }
    
    @keyframes text-gradient {
      0%, 100% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
    }
    
    /* Section Styles */
    .section-padding {
      padding: 8rem 0;
    }
    
    .container-narrow {
      max-width: 1400px;
      margin: 0 auto;
      padding: 0 2rem;
    }
    
    /* Skill Bars */
    .skill-bar {
      height: 6px;
      border-radius: 3px;
      background: rgba(255, 255, 255, 0.05);
      overflow: hidden;
      position: relative;
    }
    
    .skill-progress {
      height: 100%;
      border-radius: 3px;
      position: relative;
      transition: width 1.5s cubic-bezier(0.65, 0, 0.35, 1);
    }
    
    /* Card Hover Effects */
    .card-hover {
      transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      position: relative;
      overflow: hidden;
    }
    
    .card-hover::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(0, 102, 255, 0.1), transparent);
      transition: left 0.6s ease;
    }
    
    .card-hover:hover::before {
      left: 100%;
    }
    
    .card-hover:hover {
      transform: translateY(-5px);
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
    }
    
    /* Statistics */
    .stat-number {
      font-size: 3.5rem;
      font-weight: 800;
      background: linear-gradient(135deg, var(--tech-blue), var(--tech-cyan));
      -webkit-background-clip: text;
      background-clip: text;
      -webkit-text-fill-color: transparent;
    }
    
    /* Timeline Styles */
    .timeline-item {
      position: relative;
      padding-left: 40px;
    }
    
    .timeline-item::before {
      content: '';
      position: absolute;
      left: 0;
      top: 0;
      width: 20px;
      height: 20px;
      border-radius: 50%;
      background: var(--tech-blue);
      box-shadow: 0 0 20px var(--tech-blue);
    }
    
    .timeline-item::after {
      content: '';
      position: absolute;
      left: 9px;
      top: 20px;
      width: 2px;
      height: calc(100% + 20px);
      background: linear-gradient(to bottom, var(--tech-blue), transparent);
    }
    
    .timeline-item:last-child::after {
      display: none;
    }
    
    /* Social Card */
    .social-card {
      transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    
    .social-card:hover {
      transform: translateY(-10px) scale(1.02);
    }
    
    /* Blog Card */
    .blog-card {
      transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      position: relative;
      overflow: hidden;
    }
    
    .blog-card::after {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(45deg, transparent, rgba(0, 102, 255, 0.1), transparent);
      transform: translateX(-100%);
      transition: transform 0.6s ease;
    }
    
    .blog-card:hover::after {
      transform: translateX(100%);
    }
    
    /* GitHub Activity */
    .github-activity {
      background: linear-gradient(135deg, rgba(0, 102, 255, 0.1), rgba(0, 243, 255, 0.1));
    }
    
    /* Certification Card */
    .certification-card {
      transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      position: relative;
      overflow: hidden;
    }
    
    .certification-card:hover {
      transform: translateY(-5px) scale(1.02);
    }
    
    .certification-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 215, 0, 0.1), transparent);
      transition: left 0.6s ease;
    }
    
    .certification-card:hover::before {
      left: 100%;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
      body {
        cursor: auto !important;
      }
      
      .cursor-dot,
      .cursor-ring,
      .cursor-trail,
      .cursor-sparkle,
      .cursor-magnetic-effect,
      .cursor-ripple {
        display: none;
      }
      
      .section-padding {
        padding: 4rem 0;
      }
      
      .container-narrow {
        padding: 0 1.5rem;
      }
    }
  </style>
</head>

<body class="relative overflow-x-hidden">
  <!-- Advanced Cursor System -->
  <div class="cursor-dot"></div>
  <div class="cursor-ring"></div>
  <div class="cursor-magnetic-effect"></div>
  
  <!-- Ultra Advanced Tech Background -->
  <div id="tech-universe">
    <div class="quantum-grid"></div>
    <div class="nebula-swirl"></div>
    <div class="energy-wave"></div>
    <div class="code-matrix"></div>
    <div class="neural-network" id="neural-network"></div>
    <div class="circuit-scan" style="top: 20%; animation-delay: 0s;"></div>
    <div class="circuit-scan" style="top: 50%; animation-delay: 2s;"></div>
    <div class="circuit-scan" style="top: 80%; animation-delay: 4s;"></div>
    
    <!-- Data Streams -->
    <div class="holographic-stream" style="left: 10%; animation-delay: 0s;"></div>
    <div class="holographic-stream" style="left: 25%; animation-delay: 2s;"></div>
    <div class="holographic-stream" style="left: 40%; animation-delay: 4s;"></div>
    <div class="holographic-stream" style="left: 55%; animation-delay: 6s;"></div>
    <div class="holographic-stream" style="left: 70%; animation-delay: 8s;"></div>
    <div class="holographic-stream" style="left: 85%; animation-delay: 10s;"></div>
    
    <!-- Cyber Rain -->
    <div class="cyber-rain" style="left: 15%; animation-delay: 0s;"></div>
    <div class="cyber-rain" style="left: 30%; animation-delay: 1s;"></div>
    <div class="cyber-rain" style="left: 45%; animation-delay: 2s;"></div>
    <div class="cyber-rain" style="left: 60%; animation-delay: 3s;"></div>
    <div class="cyber-rain" style="left: 75%; animation-delay: 4s;"></div>
    <div class="cyber-rain" style="left: 90%; animation-delay: 5s;"></div>
    
    <!-- Digital Rain (Matrix) -->
    <div id="matrix-layer"></div>
    
    <!-- Quantum Particles -->
    <div id="particles-layer"></div>
    
    <!-- Particle Swarm -->
    <div class="particle-swarm" style="top: 20%; left: 10%; animation-delay: 0s;"></div>
    <div class="particle-swarm" style="top: 40%; left: 30%; animation-delay: 1s;"></div>
    <div class="particle-swarm" style="top: 60%; left: 50%; animation-delay: 2s;"></div>
    <div class="particle-swarm" style="top: 30%; left: 70%; animation-delay: 3s;"></div>
    <div class="particle-swarm" style="top: 70%; left: 90%; animation-delay: 4s;"></div>
  </div>
  
  <!-- Navigation -->
  <nav class="fixed top-0 left-0 right-0 z-50 glass-heavy py-5">
    <div class="container-narrow">
      <div class="flex items-center justify-between">
        <!-- Logo -->
        <a href="#" class="group flex items-center space-x-3">
          <div class="relative">
            <div class="absolute inset-0 bg-gradient-to-r from-tech-blue to-tech-cyan rounded-xl blur opacity-30 group-hover:opacity-50 transition-opacity animate-pulse"></div>
            <div class="relative w-10 h-10 rounded-xl bg-tech-darker flex items-center justify-center">
              <span class="text-2xl font-bold gradient-text">H</span>
            </div>
          </div>
          <div>
            <div class="font-display font-bold text-xl text-tech-gray-200">HAFIIDH</div>
            <div class="text-xs text-tech-gray-500 group-hover:text-tech-cyan transition">Digital Creator</div>
          </div>
        </a>
        
        <!-- Desktop Navigation -->
        <div class="hidden md:flex items-center space-x-10">
          <div class="flex space-x-8">
            <a href="#hero" class="text-sm text-tech-gray-400 hover:text-tech-blue transition-all duration-300 group relative">
              <span class="relative">
                Home
                <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-tech-blue group-hover:w-full transition-all duration-300"></span>
              </span>
            </a>
            <a href="#about" class="text-sm text-tech-gray-400 hover:text-tech-cyan transition-all duration-300 group relative">
              <span class="relative">
                About
                <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-tech-cyan group-hover:w-full transition-all duration-300"></span>
              </span>
            </a>
            <a href="#skills" class="text-sm text-tech-gray-400 hover:text-tech-purple transition-all duration-300 group relative">
              <span class="relative">
                Skills
                <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-tech-purple group-hover:w-full transition-all duration-300"></span>
              </span>
            </a>
            <a href="#projects" class="text-sm text-tech-gray-400 hover:text-tech-teal transition-all duration-300 group relative">
              <span class="relative">
                Projects
                <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-tech-teal group-hover:w-full transition-all duration-300"></span>
              </span>
            </a>
            <a href="#certifications" class="text-sm text-tech-gray-400 hover:text-tech-yellow transition-all duration-300 group relative">
              <span class="relative">
                Certifications
                <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-tech-yellow group-hover:w-full transition-all duration-300"></span>
              </span>
            </a>
            <a href="#github" class="text-sm text-tech-gray-400 hover:text-tech-green transition-all duration-300 group relative">
              <span class="relative">
                GitHub
                <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-tech-green group-hover:w-full transition-all duration-300"></span>
              </span>
            </a>
            <a href="#contact" class="text-sm text-tech-gray-400 hover:text-tech-pink transition-all duration-300 group relative">
              <span class="relative">
                Contact
                <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-tech-pink group-hover:w-full transition-all duration-300"></span>
              </span>
            </a>
          </div>
          
          <div class="flex items-center space-x-4">
            <div class="w-20 h-8 rounded-full glass flex items-center justify-center group">
              <div class="w-2 h-2 rounded-full bg-tech-green animate-pulse-glow group-hover:animate-pulse group-hover:scale-125 transition-transform"></div>
              <span class="ml-2 text-xs text-tech-gray-300 group-hover:text-tech-green transition">AVAILABLE</span>
            </div>
            <a href="#contact" class="px-6 py-2 rounded-full bg-gradient-to-r from-tech-blue to-tech-cyan text-tech-darker font-semibold text-sm hover:shadow-lg hover:shadow-tech-blue/30 transition-all duration-300 transform hover:-translate-y-0.5 card-hover">
              Let's Talk
            </a>
          </div>
        </div>
        
        <!-- Mobile Menu Button -->
        <button id="mobileMenuButton" class="md:hidden glass w-12 h-12 rounded-xl flex items-center justify-center group">
          <i data-feather="menu" class="w-6 h-6 text-tech-gray-200 group-hover:text-tech-blue transition"></i>
        </button>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <section id="hero" class="min-h-screen relative flex items-center justify-center overflow-hidden section-padding pt-20">
    <!-- Tech Rings -->
    <div class="absolute w-96 h-96 border border-tech-blue/10 rounded-full animate-spin-slow left-1/4 top-1/4"></div>
    <div class="absolute w-72 h-72 border border-tech-cyan/10 rounded-full animate-spin-slow right-1/3 bottom-1/3" style="animation-direction: reverse;"></div>
    
    <div class="container-narrow relative z-10">
      <div class="max-w-6xl mx-auto text-center">
        <!-- Hero Badge -->
        <div class="inline-flex items-center glass px-6 py-3 rounded-full mb-8 animate-slide-up hover:scale-105 transition-transform group">
          <div class="w-3 h-3 rounded-full bg-tech-blue animate-pulse-glow mr-2"></div>
          <span class="text-sm text-tech-gray-300">Full Stack Developer • UI/UX Designer • Digital Creator</span>
          <div class="ml-4 w-2 h-2 rounded-full bg-tech-cyan animate-pulse" style="animation-delay: 0.5s;"></div>
        </div>
        
        <!-- Main Heading -->
        <h1 class="text-6xl md:text-8xl lg:text-9xl font-display font-bold mb-6 animate-slide-up" style="animation-delay: 0.1s">
          <span class="block text-white relative">
            <span class="gradient-text">HAFIIDH</span>
            <span class="absolute -top-2 -right-2 text-xs text-tech-cyan animate-pulse">DEV</span>
          </span>
        </h1>
        
        <!-- Subheading -->
        <div class="text-2xl md:text-3xl lg:text-4xl mb-12 animate-slide-up" style="animation-delay: 0.2s">
          <div class="inline-block">
            <span class="text-tech-gray-400">Crafting </span>
            <span class="gradient-text font-bold typewriter">Digital Experiences</span>
            <span class="text-tech-blue animate-blink-caret">_</span>
          </div>
        </div>
        
        <!-- Hero Description -->
        <p class="text-xl text-tech-gray-400 max-w-3xl mx-auto mb-12 animate-slide-up" style="animation-delay: 0.3s">
          Transforming complex ideas into elegant, high-performance digital solutions. 
          Specializing in modern web development, UI/UX design, and cutting-edge technology.
        </p>
        
        <!-- CTA Buttons -->
        <div class="flex flex-wrap gap-6 justify-center animate-slide-up" style="animation-delay: 0.4s">
          <a href="#projects" class="group relative px-10 py-5 rounded-2xl bg-gradient-to-r from-tech-blue to-tech-cyan text-tech-darker font-bold text-lg overflow-hidden transform hover:scale-105 transition-all duration-300 card-hover">
            <span class="relative z-10 flex items-center">
              <i data-feather="eye" class="mr-3 w-5 h-5"></i>
              View Portfolio
            </span>
            <div class="absolute inset-0 bg-gradient-to-r from-tech-cyan to-tech-purple opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="absolute inset-0 shimmer opacity-0 group-hover:opacity-30"></div>
          </a>
          
          <a href="#contact" class="group relative px-10 py-5 rounded-2xl glass border border-tech-gray-800 hover:border-tech-cyan/50 text-white font-bold text-lg overflow-hidden transform hover:scale-105 transition-all duration-300 card-hover">
            <span class="relative z-10 flex items-center">
              <i data-feather="message-circle" class="mr-3 w-5 h-5"></i>
              Start Project
            </span>
            <div class="absolute inset-0 bg-gradient-to-r from-tech-cyan/10 to-tech-purple/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
          </a>
        </div>
        
        <!-- Scroll Indicator -->
        <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 animate-bounce-slow">
          <a href="#about" class="flex flex-col items-center group">
            <span class="text-xs text-tech-gray-500 mb-2 group-hover:text-tech-cyan transition">EXPLORE</span>
            <div class="w-8 h-12 rounded-full glass border border-tech-gray-800 group-hover:border-tech-cyan transition flex justify-center relative overflow-hidden">
              <div class="absolute inset-0 bg-gradient-to-b from-tech-cyan/0 via-tech-cyan/50 to-tech-cyan/0 animate-particle-flow"></div>
              <div class="w-1.5 h-4 bg-tech-cyan rounded-full mt-2 animate-pulse z-10"></div>
            </div>
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- Statistics Section -->
  <section id="stats" class="relative section-padding">
    <div class="container-narrow">
      <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
        <div class="text-center glass rounded-3xl p-8 border border-tech-gray-800 hover:border-tech-blue/50 transition-all duration-300 card-hover">
          <div class="stat-number animate-count" data-target="50">0+</div>
          <div class="text-tech-gray-400 mt-2">Projects Completed</div>
        </div>
        
        <div class="text-center glass rounded-3xl p-8 border border-tech-gray-800 hover:border-tech-purple/50 transition-all duration-300 card-hover">
          <div class="stat-number animate-count" data-target="3">0+</div>
          <div class="text-tech-gray-400 mt-2">Years Experience</div>
        </div>
        
        <div class="text-center glass rounded-3xl p-8 border border-tech-gray-800 hover:border-tech-pink/50 transition-all duration-300 card-hover">
          <div class="stat-number animate-count" data-target="100">100%</div>
          <div class="text-tech-gray-400 mt-2">Client Satisfaction</div>
        </div>
        
        <div class="text-center glass rounded-3xl p-8 border border-tech-gray-800 hover:border-tech-blue/50 transition-all duration-300 card-hover">
          <div class="stat-number animate-count" data-target="24">0/7</div>
          <div class="text-tech-gray-400 mt-2">Support Available</div>
        </div>
      </div>
    </div>
  </section>

  <!-- About Section -->
  <section id="about" class="relative section-padding">
    <div class="container-narrow">
      <div class="text-center mb-16">
        <div class="inline-flex items-center mb-8">
          <div class="w-16 h-0.5 bg-gradient-to-r from-tech-blue to-tech-cyan"></div>
          <span class="mx-4 text-tech-blue font-mono text-sm">ABOUT ME</span>
          <div class="w-16 h-0.5 bg-gradient-to-r from-tech-cyan to-tech-blue"></div>
        </div>
        
        <h2 class="text-4xl md:text-5xl font-display font-bold mb-8">
          The
          <span class="gradient-text">Developer</span>
          Behind The Code
        </h2>
      </div>
      
      <div class="grid lg:grid-cols-2 gap-16 items-center">
        <!-- Profile Image -->
        <div class="relative group">
          <div class="absolute -inset-4 bg-gradient-to-r from-tech-blue to-tech-cyan rounded-3xl blur-xl opacity-0 group-hover:opacity-30 transition-opacity duration-500"></div>
          <div class="relative glass rounded-3xl overflow-hidden border border-tech-gray-800 group-hover:border-tech-blue/50 transition-all duration-300">
            <div class="aspect-square relative">
              <!-- Professional Image Placeholder -->
              <div class="absolute inset-0 bg-gradient-to-br from-tech-blue/10 via-tech-cyan/10 to-tech-purple/10 flex items-center justify-center">
                <div class="text-center p-8">
                  <div class="w-64 h-64 rounded-full mx-auto mb-6 overflow-hidden border-4 border-tech-gray-800 relative group-hover:border-tech-blue/50 transition-all duration-300">
                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" 
                         alt="Professional Developer" 
                         class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-tech-dark/50 to-transparent"></div>
                  </div>
                  <h3 class="text-2xl font-bold text-white mb-2">Hafiidh Y. Ramadhani</h3>
                  <p class="text-tech-cyan font-mono">Full Stack Developer</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- About Content -->
        <div class="space-y-8">
          <div class="glass rounded-2xl p-8 border border-tech-gray-800 hover:border-tech-blue/50 transition-all duration-300 card-hover">
            <h3 class="text-2xl font-bold text-white mb-4 flex items-center">
              <i data-feather="code" class="w-6 h-6 mr-3 text-tech-blue"></i>
              My Journey
            </h3>
            <p class="text-tech-gray-300">
              As an Informatics Engineering student at ITENAS Malang, I've spent years mastering 
              the art of digital creation. From building simple websites to complex web applications, 
              my journey has been about solving real-world problems with elegant code.
            </p>
          </div>
          
          <div class="glass rounded-2xl p-8 border border-tech-gray-800 hover:border-tech-cyan/50 transition-all duration-300 card-hover">
            <h3 class="text-2xl font-bold text-white mb-4 flex items-center">
              <i data-feather="target" class="w-6 h-6 mr-3 text-tech-cyan"></i>
              Philosophy
            </h3>
            <p class="text-tech-gray-300">
              I believe great digital experiences come from the perfect blend of design and technology. 
              Every project is an opportunity to push boundaries, innovate, and create something 
              that not only works flawlessly but also delights users.
            </p>
          </div>
          
          <div class="glass rounded-2xl p-8 border border-tech-gray-800 hover:border-tech-purple/50 transition-all duration-300 card-hover">
            <h3 class="text-2xl font-bold text-white mb-4 flex items-center">
              <i data-feather="award" class="w-6 h-6 mr-3 text-tech-purple"></i>
              Approach
            </h3>
            <p class="text-tech-gray-300">
              Clean code, modern design, and user-focused solutions. I follow agile methodologies, 
              ensuring transparency, regular updates, and the flexibility to adapt to changing requirements.
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Skills Section -->
  <section id="skills" class="relative section-padding">
    <div class="container-narrow">
      <div class="text-center mb-16">
        <div class="inline-flex items-center mb-8">
          <div class="w-16 h-0.5 bg-gradient-to-r from-tech-purple to-tech-pink"></div>
          <span class="mx-4 text-tech-purple font-mono text-sm">TECHNICAL SKILLS</span>
          <div class="w-16 h-0.5 bg-gradient-to-r from-tech-pink to-tech-purple"></div>
        </div>
        
        <h2 class="text-4xl md:text-5xl font-display font-bold mb-8">
          My
          <span class="gradient-text">Expertise</span>
        </h2>
      </div>
      
      <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
        <!-- Frontend Skills -->
        <div class="glass rounded-3xl p-8 border border-tech-gray-800 hover:border-tech-blue/50 transition-all duration-300 card-hover">
          <div class="flex items-center mb-6">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-tech-blue to-tech-cyan flex items-center justify-center mr-4">
              <i data-feather="layout" class="w-6 h-6 text-tech-darker"></i>
            </div>
            <div>
              <h3 class="text-xl font-bold text-white">Frontend</h3>
              <p class="text-sm text-tech-gray-400">Modern UI Development</p>
            </div>
          </div>
          
          <div class="space-y-4">
            <div>
              <div class="flex justify-between mb-2">
                <span class="text-sm text-tech-gray-300">React.js</span>
                <span class="text-sm text-tech-blue">95%</span>
              </div>
              <div class="skill-bar">
                <div class="skill-progress bg-gradient-to-r from-tech-blue to-tech-cyan" style="width: 0%" data-width="95%"></div>
              </div>
            </div>
            
            <div>
              <div class="flex justify-between mb-2">
                <span class="text-sm text-tech-gray-300">Vue.js</span>
                <span class="text-sm text-tech-cyan">85%</span>
              </div>
              <div class="skill-bar">
                <div class="skill-progress bg-gradient-to-r from-tech-cyan to-tech-purple" style="width: 0%" data-width="85%"></div>
              </div>
            </div>
            
            <div>
              <div class="flex justify-between mb-2">
                <span class="text-sm text-tech-gray-300">Tailwind CSS</span>
                <span class="text-sm text-tech-purple">98%</span>
              </div>
              <div class="skill-bar">
                <div class="skill-progress bg-gradient-to-r from-tech-purple to-tech-pink" style="width: 0%" data-width="98%"></div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Backend Skills -->
        <div class="glass rounded-3xl p-8 border border-tech-gray-800 hover:border-tech-cyan/50 transition-all duration-300 card-hover">
          <div class="flex items-center mb-6">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-tech-cyan to-tech-purple flex items-center justify-center mr-4">
              <i data-feather="server" class="w-6 h-6 text-tech-darker"></i>
            </div>
            <div>
              <h3 class="text-xl font-bold text-white">Backend</h3>
              <p class="text-sm text-tech-gray-400">Server-side Development</p>
            </div>
          </div>
          
          <div class="space-y-4">
            <div>
              <div class="flex justify-between mb-2">
                <span class="text-sm text-tech-gray-300">Laravel</span>
                <span class="text-sm text-tech-cyan">90%</span>
              </div>
              <div class="skill-bar">
                <div class="skill-progress bg-gradient-to-r from-tech-cyan to-tech-blue" style="width: 0%" data-width="90%"></div>
              </div>
            </div>
            
            <div>
              <div class="flex justify-between mb-2">
                <span class="text-sm text-tech-gray-300">Node.js</span>
                <span class="text-sm text-tech-blue">88%</span>
              </div>
              <div class="skill-bar">
                <div class="skill-progress bg-gradient-to-r from-tech-blue to-tech-purple" style="width: 0%" data-width="88%"></div>
              </div>
            </div>
            
            <div>
              <div class="flex justify-between mb-2">
                <span class="text-sm text-tech-gray-300">MySQL</span>
                <span class="text-sm text-tech-purple">92%</span>
              </div>
              <div class="skill-bar">
                <div class="skill-progress bg-gradient-to-r from-tech-purple to-tech-green" style="width: 0%" data-width="92%"></div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Design & Tools -->
        <div class="glass rounded-3xl p-8 border border-tech-gray-800 hover:border-tech-pink/50 transition-all duration-300 card-hover">
          <div class="flex items-center mb-6">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-tech-pink to-tech-blue flex items-center justify-center mr-4">
              <i data-feather="tool" class="w-6 h-6 text-tech-darker"></i>
            </div>
            <div>
              <h3 class="text-xl font-bold text-white">Design & Tools</h3>
              <p class="text-sm text-tech-gray-400">UI/UX & Development Tools</p>
            </div>
          </div>
          
          <div class="space-y-4">
            <div>
              <div class="flex justify-between mb-2">
                <span class="text-sm text-tech-gray-300">Figma</span>
                <span class="text-sm text-tech-pink">95%</span>
              </div>
              <div class="skill-bar">
                <div class="skill-progress bg-gradient-to-r from-tech-pink to-tech-purple" style="width: 0%" data-width="95%"></div>
              </div>
            </div>
            
            <div>
              <div class="flex justify-between mb-2">
                <span class="text-sm text-tech-gray-300">Git</span>
                <span class="text-sm text-tech-purple">98%</span>
              </div>
              <div class="skill-bar">
                <div class="skill-progress bg-gradient-to-r from-tech-purple to-tech-blue" style="width: 0%" data-width="98%"></div>
              </div>
            </div>
            
            <div>
              <div class="flex justify-between mb-2">
                <span class="text-sm text-tech-gray-300">Three.js</span>
                <span class="text-sm text-tech-blue">75%</span>
              </div>
              <div class="skill-bar">
                <div class="skill-progress bg-gradient-to-r from-tech-blue to-tech-green" style="width: 0%" data-width="75%"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Projects Section -->
  <section id="projects" class="relative section-padding">
    <div class="container-narrow">
      <div class="text-center mb-16">
        <div class="inline-flex items-center mb-8">
          <div class="w-16 h-0.5 bg-gradient-to-r from-tech-green to-tech-cyan"></div>
          <span class="mx-4 text-tech-green font-mono text-sm">FEATURED WORK</span>
          <div class="w-16 h-0.5 bg-gradient-to-r from-tech-cyan to-tech-green"></div>
        </div>
        
        <h2 class="text-4xl md:text-5xl font-display font-bold mb-8">
          Recent
          <span class="gradient-text">Projects</span>
        </h2>
      </div>
      
      <!-- Projects Grid -->
      <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
        <!-- Project 1 -->
        <div class="glass rounded-3xl overflow-hidden border border-tech-gray-800 hover:border-tech-blue/50 transition-all duration-300 card-hover">
          <div class="h-48 bg-gradient-to-br from-tech-blue/20 to-tech-cyan/20 relative overflow-hidden flex items-center justify-center">
            <i data-feather="briefcase" class="w-16 h-16 text-tech-blue opacity-30"></i>
          </div>
          <div class="p-6">
            <h3 class="text-xl font-bold text-white mb-2">E-Commerce Platform</h3>
            <p class="text-tech-gray-400 mb-4">Full-stack e-commerce solution with React & Laravel</p>
            <div class="flex flex-wrap gap-2 mb-4">
              <span class="text-xs px-3 py-1 bg-tech-blue/10 text-tech-blue rounded-full">React</span>
              <span class="text-xs px-3 py-1 bg-tech-cyan/10 text-tech-cyan rounded-full">Laravel</span>
              <span class="text-xs px-3 py-1 bg-tech-purple/10 text-tech-purple rounded-full">MySQL</span>
            </div>
          </div>
        </div>
        
        <!-- Project 2 -->
        <div class="glass rounded-3xl overflow-hidden border border-tech-gray-800 hover:border-tech-cyan/50 transition-all duration-300 card-hover">
          <div class="h-48 bg-gradient-to-br from-tech-cyan/20 to-tech-purple/20 relative overflow-hidden flex items-center justify-center">
            <i data-feather="layout" class="w-16 h-16 text-tech-cyan opacity-30"></i>
          </div>
          <div class="p-6">
            <h3 class="text-xl font-bold text-white mb-2">Dashboard UI</h3>
            <p class="text-tech-gray-400 mb-4">Analytics dashboard with real-time data visualization</p>
            <div class="flex flex-wrap gap-2 mb-4">
              <span class="text-xs px-3 py-1 bg-tech-blue/10 text-tech-blue rounded-full">Vue.js</span>
              <span class="text-xs px-3 py-1 bg-tech-cyan/10 text-tech-cyan rounded-full">D3.js</span>
              <span class="text-xs px-3 py-1 bg-tech-purple/10 text-tech-purple rounded-full">Tailwind</span>
            </div>
          </div>
        </div>
        
        <!-- Project 3 -->
        <div class="glass rounded-3xl overflow-hidden border border-tech-gray-800 hover:border-tech-purple/50 transition-all duration-300 card-hover">
          <div class="h-48 bg-gradient-to-br from-tech-purple/20 to-tech-pink/20 relative overflow-hidden flex items-center justify-center">
            <i data-feather="smartphone" class="w-16 h-16 text-tech-purple opacity-30"></i>
          </div>
          <div class="p-6">
            <h3 class="text-xl font-bold text-white mb-2">Mobile App</h3>
            <p class="text-tech-gray-400 mb-4">Cross-platform mobile application with React Native</p>
            <div class="flex flex-wrap gap-2 mb-4">
              <span class="text-xs px-3 py-1 bg-tech-blue/10 text-tech-blue rounded-full">React Native</span>
              <span class="text-xs px-3 py-1 bg-tech-cyan/10 text-tech-cyan rounded-full">Firebase</span>
              <span class="text-xs px-3 py-1 bg-tech-purple/10 text-tech-purple rounded-full">Redux</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Certifications Section -->
  <section id="certifications" class="relative section-padding">
    <div class="container-narrow">
      <div class="text-center mb-16">
        <div class="inline-flex items-center mb-8">
          <div class="w-16 h-0.5 bg-gradient-to-r from-tech-yellow to-tech-orange"></div>
          <span class="mx-4 text-tech-yellow font-mono text-sm">CERTIFICATIONS</span>
          <div class="w-16 h-0.5 bg-gradient-to-r from-tech-orange to-tech-yellow"></div>
        </div>
        
        <h2 class="text-4xl md:text-5xl font-display font-bold mb-8">
          Professional
          <span class="gradient-text">Certifications</span>
        </h2>
      </div>
      
      <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
        <!-- Certification 1 -->
        <div class="certification-card glass rounded-3xl p-8 border border-tech-gray-800 hover:border-tech-yellow/50 transition-all duration-300">
          <div class="flex items-center mb-6">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-tech-yellow/20 to-tech-orange/20 flex items-center justify-center mr-4">
              <i data-feather="award" class="w-8 h-8 text-tech-yellow"></i>
            </div>
            <div>
              <h3 class="text-xl font-bold text-white">AWS Certified</h3>
              <p class="text-sm text-tech-gray-400">Solutions Architect</p>
            </div>
          </div>
          <p class="text-tech-gray-300 mb-4">Amazon Web Services certification for designing distributed systems on AWS.</p>
          <div class="flex items-center text-tech-yellow text-sm">
            <span>Issued: 2024</span>
            <i data-feather="external-link" class="w-4 h-4 ml-2"></i>
          </div>
        </div>
        
        <!-- Certification 2 -->
        <div class="certification-card glass rounded-3xl p-8 border border-tech-gray-800 hover:border-tech-cyan/50 transition-all duration-300">
          <div class="flex items-center mb-6">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-tech-cyan/20 to-tech-blue/20 flex items-center justify-center mr-4">
              <i data-feather="code" class="w-8 h-8 text-tech-cyan"></i>
            </div>
            <div>
              <h3 class="text-xl font-bold text-white">React Developer</h3>
              <p class="text-sm text-tech-gray-400">Advanced Certification</p>
            </div>
          </div>
          <p class="text-tech-gray-300 mb-4">Advanced React patterns, performance optimization, and best practices.</p>
          <div class="flex items-center text-tech-cyan text-sm">
            <span>Issued: 2023</span>
            <i data-feather="external-link" class="w-4 h-4 ml-2"></i>
          </div>
        </div>
        
        <!-- Certification 3 -->
        <div class="certification-card glass rounded-3xl p-8 border border-tech-gray-800 hover:border-tech-purple/50 transition-all duration-300">
          <div class="flex items-center mb-6">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-tech-purple/20 to-tech-pink/20 flex items-center justify-center mr-4">
              <i data-feather="shield" class="w-8 h-8 text-tech-purple"></i>
            </div>
            <div>
              <h3 class="text-xl font-bold text-white">Cybersecurity</h3>
              <p class="text-sm text-tech-gray-400">Web Security Specialist</p>
            </div>
          </div>
          <p class="text-tech-gray-300 mb-4">Web application security, penetration testing, and secure coding practices.</p>
          <div class="flex items-center text-tech-purple text-sm">
            <span>Issued: 2023</span>
            <i data-feather="external-link" class="w-4 h-4 ml-2"></i>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- GitHub Section -->
  <section id="github" class="relative section-padding">
    <div class="container-narrow">
      <div class="text-center mb-16">
        <div class="inline-flex items-center mb-8">
          <div class="w-16 h-0.5 bg-gradient-to-r from-tech-green to-tech-blue"></div>
          <span class="mx-4 text-tech-green font-mono text-sm">GITHUB ACTIVITY</span>
          <div class="w-16 h-0.5 bg-gradient-to-r from-tech-blue to-tech-green"></div>
        </div>
        
        <h2 class="text-4xl md:text-5xl font-display font-bold mb-8">
          Live
          <span class="gradient-text">Code Activity</span>
        </h2>
      </div>
      
      <div class="grid lg:grid-cols-2 gap-16">
        <!-- GitHub Stats -->
        <div class="github-activity glass rounded-3xl p-8 border border-tech-gray-800">
          <h3 class="text-2xl font-bold text-white mb-6 flex items-center">
            <i data-feather="github" class="w-6 h-6 mr-3 text-tech-green"></i>
            GitHub Statistics
          </h3>
          
          <div class="grid grid-cols-2 gap-6 mb-8">
            <div class="text-center">
              <div class="text-4xl font-bold text-white mb-2" id="github-repos">0</div>
              <p class="text-tech-gray-400">Public Repositories</p>
            </div>
            <div class="text-center">
              <div class="text-4xl font-bold text-white mb-2" id="github-stars">0</div>
              <p class="text-tech-gray-400">Total Stars</p>
            </div>
          </div>
          
          <div class="space-y-4">
            <div>
              <div class="flex justify-between mb-2">
                <span class="text-sm text-tech-gray-300">JavaScript</span>
                <span class="text-sm text-tech-yellow">65%</span>
              </div>
              <div class="skill-bar">
                <div class="skill-progress bg-gradient-to-r from-tech-yellow to-tech-orange" style="width: 65%"></div>
              </div>
            </div>
            <div>
              <div class="flex justify-between mb-2">
                <span class="text-sm text-tech-gray-300">PHP</span>
                <span class="text-sm text-tech-purple">25%</span>
              </div>
              <div class="skill-bar">
                <div class="skill-progress bg-gradient-to-r from-tech-purple to-tech-pink" style="width: 25%"></div>
              </div>
            </div>
            <div>
              <div class="flex justify-between mb-2">
                <span class="text-sm text-tech-gray-300">Python</span>
                <span class="text-sm text-tech-blue">10%</span>
              </div>
              <div class="skill-bar">
                <div class="skill-progress bg-gradient-to-r from-tech-blue to-tech-cyan" style="width: 10%"></div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Recent Activity -->
        <div class="glass rounded-3xl p-8 border border-tech-gray-800">
          <h3 class="text-2xl font-bold text-white mb-6 flex items-center">
            <i data-feather="activity" class="w-6 h-6 mr-3 text-tech-cyan"></i>
            Recent Activity
          </h3>
          
          <div class="space-y-4" id="github-activity">
            <!-- Activities will be loaded here -->
            <div class="flex items-start space-x-4 animate-pulse">
              <div class="w-10 h-10 rounded-full bg-tech-gray-800"></div>
              <div class="flex-1">
                <div class="h-4 bg-tech-gray-800 rounded mb-2"></div>
                <div class="h-3 bg-tech-gray-800 rounded w-3/4"></div>
              </div>
            </div>
            <div class="flex items-start space-x-4 animate-pulse">
              <div class="w-10 h-10 rounded-full bg-tech-gray-800"></div>
              <div class="flex-1">
                <div class="h-4 bg-tech-gray-800 rounded mb-2"></div>
                <div class="h-3 bg-tech-gray-800 rounded w-1/2"></div>
              </div>
            </div>
          </div>
          
          <a href="https://github.com/Fiidhanz" target="_blank" 
             class="mt-8 inline-flex items-center px-6 py-3 rounded-xl bg-gradient-to-r from-tech-green to-tech-cyan text-tech-darker font-semibold hover:shadow-lg hover:shadow-tech-green/30 transition-all duration-300 transform hover:-translate-y-0.5">
            <i data-feather="github" class="w-5 h-5 mr-2"></i>
            View GitHub Profile
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- Social Media Section -->
  <section id="social" class="relative section-padding">
    <div class="container-narrow">
      <div class="text-center mb-16">
        <div class="inline-flex items-center mb-8">
          <div class="w-16 h-0.5 bg-gradient-to-r from-tech-green to-tech-cyan"></div>
          <span class="mx-4 text-tech-green font-mono text-sm">SOCIAL PRESENCE</span>
          <div class="w-16 h-0.5 bg-gradient-to-r from-tech-cyan to-tech-green"></div>
        </div>
        
        <h2 class="text-4xl md:text-5xl font-display font-bold mb-8">
          Connect
          <span class="gradient-text">With Me</span>
        </h2>
      </div>
      
      <!-- Social Media Cards -->
      <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
        <!-- GitHub -->
        <a href="https://github.com/Fiidhanz" target="_blank" 
           class="social-card glass rounded-3xl p-8 border border-tech-gray-800 hover:border-tech-blue/50 transition-all duration-300 group">
          <div class="flex items-center mb-6">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-gray-900 to-gray-800 flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
              <i data-feather="github" class="w-8 h-8 text-white"></i>
            </div>
            <div>
              <h3 class="text-xl font-bold text-white">GitHub</h3>
              <p class="text-sm text-tech-gray-400">Code Repository</p>
            </div>
          </div>
          <p class="text-tech-gray-300 mb-4">Explore my open-source projects, contributions, and code samples.</p>
          <div class="flex items-center text-tech-blue text-sm">
            <span>@Fiidhanz</span>
            <i data-feather="arrow-up-right" class="w-4 h-4 ml-2"></i>
          </div>
        </a>
        
        <!-- LinkedIn -->
        <a href="https://www.linkedin.com/in/hafiidh-yupiza-ramadhani-23506b213" target="_blank" 
           class="social-card glass rounded-3xl p-8 border border-tech-gray-800 hover:border-tech-cyan/50 transition-all duration-300 group">
          <div class="flex items-center mb-6">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-900 to-blue-800 flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
              <i data-feather="linkedin" class="w-8 h-8 text-white"></i>
            </div>
            <div>
              <h3 class="text-xl font-bold text-white">LinkedIn</h3>
              <p class="text-sm text-tech-gray-400">Professional Network</p>
            </div>
          </div>
          <p class="text-tech-gray-300 mb-4">Connect professionally and explore career opportunities.</p>
          <div class="flex items-center text-tech-cyan text-sm">
            <span>Hafiidh Yupiza Ramadhani</span>
            <i data-feather="arrow-up-right" class="w-4 h-4 ml-2"></i>
          </div>
        </a>
        
        <!-- Instagram -->
        <a href="https://instagram.com/upza.sign_" target="_blank" 
           class="social-card glass rounded-3xl p-8 border border-tech-gray-800 hover:border-tech-purple/50 transition-all duration-300 group">
          <div class="flex items-center mb-6">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-pink-900 to-purple-800 flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
              <i data-feather="instagram" class="w-8 h-8 text-white"></i>
            </div>
            <div>
              <h3 class="text-xl font-bold text-white">Instagram</h3>
              <p class="text-sm text-tech-gray-400">Creative Showcase</p>
            </div>
          </div>
          <p class="text-tech-gray-300 mb-4">Behind-the-scenes and creative process updates.</p>
          <div class="flex items-center text-tech-purple text-sm">
            <span>@upza.sign_</span>
            <i data-feather="arrow-up-right" class="w-4 h-4 ml-2"></i>
          </div>
        </a>
      </div>
    </div>
  </section>

  <!-- Blog/Articles Section -->
  <section id="blog" class="relative section-padding">
    <div class="container-narrow">
      <div class="text-center mb-16">
        <div class="inline-flex items-center mb-8">
          <div class="w-16 h-0.5 bg-gradient-to-r from-tech-yellow to-tech-orange"></div>
          <span class="mx-4 text-tech-yellow font-mono text-sm">LATEST INSIGHTS</span>
          <div class="w-16 h-0.5 bg-gradient-to-r from-tech-orange to-tech-yellow"></div>
        </div>
        
        <h2 class="text-4xl md:text-5xl font-display font-bold mb-8">
          Tech
          <span class="gradient-text">Insights</span>
        </h2>
      </div>
      
      <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
        <!-- Blog Post 1 -->
        <div class="blog-card glass rounded-3xl overflow-hidden border border-tech-gray-800 hover:border-tech-blue/50 transition-all duration-300">
          <div class="h-48 bg-gradient-to-br from-tech-blue/20 to-tech-cyan/20 relative overflow-hidden flex items-center justify-center">
            <i data-feather="code" class="w-16 h-16 text-white opacity-30"></i>
          </div>
          <div class="p-6">
            <div class="flex items-center mb-4">
              <span class="text-xs px-3 py-1 glass rounded-full text-tech-blue">Development</span>
              <span class="text-xs text-tech-gray-500 ml-4">Mar 15, 2024</span>
            </div>
            <h3 class="text-xl font-bold text-white mb-3">Modern React Patterns 2024</h3>
            <p class="text-tech-gray-400 mb-4">Exploring the latest React patterns and best practices for scalable applications.</p>
            <a href="#" class="text-tech-blue hover:text-tech-cyan transition flex items-center text-sm">
              Read Article
              <i data-feather="arrow-right" class="w-4 h-4 ml-2"></i>
            </a>
          </div>
        </div>
        
        <!-- Blog Post 2 -->
        <div class="blog-card glass rounded-3xl overflow-hidden border border-tech-gray-800 hover:border-tech-cyan/50 transition-all duration-300">
          <div class="h-48 bg-gradient-to-br from-tech-cyan/20 to-tech-purple/20 relative overflow-hidden flex items-center justify-center">
            <i data-feather="layout" class="w-16 h-16 text-white opacity-30"></i>
          </div>
          <div class="p-6">
            <div class="flex items-center mb-4">
              <span class="text-xs px-3 py-1 glass rounded-full text-tech-cyan">Design</span>
              <span class="text-xs text-tech-gray-500 ml-4">Feb 28, 2024</span>
            </div>
            <h3 class="text-xl font-bold text-white mb-3">UI/UX Trends 2024</h3>
            <p class="text-tech-gray-400 mb-4">The future of user interface design and user experience principles.</p>
            <a href="#" class="text-tech-cyan hover:text-tech-purple transition flex items-center text-sm">
              Read Article
              <i data-feather="arrow-right" class="w-4 h-4 ml-2"></i>
            </a>
          </div>
        </div>
        
        <!-- Blog Post 3 -->
        <div class="blog-card glass rounded-3xl overflow-hidden border border-tech-gray-800 hover:border-tech-purple/50 transition-all duration-300">
          <div class="h-48 bg-gradient-to-br from-tech-purple/20 to-tech-pink/20 relative overflow-hidden flex items-center justify-center">
            <i data-feather="zap" class="w-16 h-16 text-white opacity-30"></i>
          </div>
          <div class="p-6">
            <div class="flex items-center mb-4">
              <span class="text-xs px-3 py-1 glass rounded-full text-tech-purple">Performance</span>
              <span class="text-xs text-tech-gray-500 ml-4">Feb 10, 2024</span>
            </div>
            <h3 class="text-xl font-bold text-white mb-3">Web Performance Optimization</h3>
            <p class="text-tech-gray-400 mb-4">Advanced techniques for optimizing web application performance.</p>
            <a href="#" class="text-tech-purple hover:text-tech-pink transition flex items-center text-sm">
              Read Article
              <i data-feather="arrow-right" class="w-4 h-4 ml-2"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Testimonials Section -->
  <section id="testimonials" class="relative section-padding">
    <div class="container-narrow">
      <div class="text-center mb-16">
        <div class="inline-flex items-center mb-8">
          <div class="w-16 h-0.5 bg-gradient-to-r from-tech-cyan to-tech-green"></div>
          <span class="mx-4 text-tech-cyan font-mono text-sm">CLIENT TESTIMONIALS</span>
          <div class="w-16 h-0.5 bg-gradient-to-r from-tech-green to-tech-cyan"></div>
        </div>
        
        <h2 class="text-4xl md:text-5xl font-display font-bold mb-8">
          What
          <span class="gradient-text">Clients Say</span>
        </h2>
      </div>
      
      <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
        <!-- Testimonial 1 -->
        <div class="glass rounded-3xl p-8 border border-tech-gray-800 hover:border-tech-blue/50 transition-all duration-300 card-hover">
          <div class="flex items-center mb-6">
            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-tech-blue to-tech-cyan flex items-center justify-center mr-4">
              <span class="text-white font-bold">JS</span>
            </div>
            <div>
              <h4 class="font-bold text-white">John Smith</h4>
              <p class="text-sm text-tech-gray-400">CEO, TechCorp</p>
            </div>
          </div>
          <p class="text-tech-gray-300 italic mb-6">"Exceptional work! Hafiidh delivered exactly what we needed, on time and with incredible attention to detail."</p>
          <div class="flex text-tech-yellow">
            <i data-feather="star" class="w-4 h-4 fill-current"></i>
            <i data-feather="star" class="w-4 h-4 fill-current ml-1"></i>
            <i data-feather="star" class="w-4 h-4 fill-current ml-1"></i>
            <i data-feather="star" class="w-4 h-4 fill-current ml-1"></i>
            <i data-feather="star" class="w-4 h-4 fill-current ml-1"></i>
          </div>
        </div>
        
        <!-- Testimonial 2 -->
        <div class="glass rounded-3xl p-8 border border-tech-gray-800 hover:border-tech-cyan/50 transition-all duration-300 card-hover">
          <div class="flex items-center mb-6">
            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-tech-cyan to-tech-purple flex items-center justify-center mr-4">
              <span class="text-white font-bold">SA</span>
            </div>
            <div>
              <h4 class="font-bold text-white">Sarah Anderson</h4>
              <p class="text-sm text-tech-gray-400">Product Manager</p>
            </div>
          </div>
          <p class="text-tech-gray-300 italic mb-6">"The level of professionalism and technical expertise was outstanding. Highly recommended!"</p>
          <div class="flex text-tech-yellow">
            <i data-feather="star" class="w-4 h-4 fill-current"></i>
            <i data-feather="star" class="w-4 h-4 fill-current ml-1"></i>
            <i data-feather="star" class="w-4 h-4 fill-current ml-1"></i>
            <i data-feather="star" class="w-4 h-4 fill-current ml-1"></i>
            <i data-feather="star" class="w-4 h-4 fill-current ml-1"></i>
          </div>
        </div>
        
        <!-- Testimonial 3 -->
        <div class="glass rounded-3xl p-8 border border-tech-gray-800 hover:border-tech-purple/50 transition-all duration-300 card-hover">
          <div class="flex items-center mb-6">
            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-tech-purple to-tech-pink flex items-center justify-center mr-4">
              <span class="text-white font-bold">MR</span>
            </div>
            <div>
              <h4 class="font-bold text-white">Michael Rodriguez</h4>
              <p class="text-sm text-tech-gray-400">Startup Founder</p>
            </div>
          </div>
          <p class="text-tech-gray-300 italic mb-6">"Transformed our vision into reality with skill and creativity. Will definitely work together again!"</p>
          <div class="flex text-tech-yellow">
            <i data-feather="star" class="w-4 h-4 fill-current"></i>
            <i data-feather="star" class="w-4 h-4 fill-current ml-1"></i>
            <i data-feather="star" class="w-4 h-4 fill-current ml-1"></i>
            <i data-feather="star" class="w-4 h-4 fill-current ml-1"></i>
            <i data-feather="star" class="w-4 h-4 fill-current ml-1"></i>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Contact Section -->
  <section id="contact" class="relative section-padding">
    <div class="container-narrow">
      <div class="text-center mb-16">
        <div class="inline-flex items-center mb-8">
          <div class="w-16 h-0.5 bg-gradient-to-r from-tech-blue to-tech-cyan"></div>
          <span class="mx-4 text-tech-blue font-mono text-sm">GET IN TOUCH</span>
          <div class="w-16 h-0.5 bg-gradient-to-r from-tech-cyan to-tech-blue"></div>
        </div>
        
        <h2 class="text-4xl md:text-6xl font-display font-bold mb-8">
          Let's Create
          <span class="gradient-text">Together</span>
        </h2>
        
        <p class="text-xl text-tech-gray-400 max-w-2xl mx-auto">
          Have a project in mind? Let's collaborate and bring your vision to life.
        </p>
      </div>
      
      <div class="grid lg:grid-cols-2 gap-16">
        <!-- Contact Info -->
        <div class="space-y-8">
          <div class="group relative card-hover">
            <div class="absolute inset-0 bg-gradient-to-r from-tech-blue/10 to-tech-cyan/10 rounded-2xl blur-xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            <div class="relative glass rounded-2xl p-8 border border-tech-gray-800 group-hover:border-tech-blue/50 transition">
              <div class="flex items-start space-x-4">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-tech-blue to-tech-cyan flex items-center justify-center flex-shrink-0">
                  <i data-feather="mail" class="w-6 h-6 text-tech-darker"></i>
                </div>
                <div>
                  <h3 class="text-xl font-bold text-tech-gray-200 mb-2">Email</h3>
                  <a href="mailto:hafiidhramadhani@gmail.com" class="text-tech-blue hover:text-tech-cyan transition text-lg">
                    hafiidhramadhani@gmail.com
                  </a>
                  <p class="text-tech-gray-400 mt-2">Usually respond within 24 hours</p>
                </div>
              </div>
            </div>
          </div>
          
          <div class="group relative card-hover">
            <div class="absolute inset-0 bg-gradient-to-r from-tech-cyan/10 to-tech-purple/10 rounded-2xl blur-xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            <div class="relative glass rounded-2xl p-8 border border-tech-gray-800 group-hover:border-tech-cyan/50 transition">
              <div class="flex items-start space-x-4">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-tech-cyan to-tech-purple flex items-center justify-center flex-shrink-0">
                  <i data-feather="map-pin" class="w-6 h-6 text-tech-darker"></i>
                </div>
                <div>
                  <h3 class="text-xl font-bold text-tech-gray-200 mb-2">Location</h3>
                  <p class="text-tech-gray-300 text-lg">Malang, Indonesia</p>
                  <p class="text-tech-gray-400 mt-2">Available for remote work worldwide</p>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Quick Links -->
          <div class="glass rounded-2xl p-8 border border-tech-gray-800 card-hover">
            <h3 class="text-xl font-bold text-tech-gray-200 mb-6">Quick Links</h3>
            <div class="grid grid-cols-2 gap-4">
              <a href="https://drive.google.com/file/d/1ZK7MkbdRxdu8jfDEyJPbupUwI9QUMf6s/view" target="_blank" 
                 class="flex items-center p-3 glass rounded-lg hover:border-tech-blue/50 border border-tech-gray-800 transition group">
                <i data-feather="file-text" class="w-5 h-5 text-tech-gray-400 group-hover:text-tech-blue transition mr-3"></i>
                <span class="text-sm text-tech-gray-300 group-hover:text-white">Resume</span>
              </a>
              <a href="#projects" 
                 class="flex items-center p-3 glass rounded-lg hover:border-tech-cyan/50 border border-tech-gray-800 transition group">
                <i data-feather="briefcase" class="w-5 h-5 text-tech-gray-400 group-hover:text-tech-cyan transition mr-3"></i>
                <span class="text-sm text-tech-gray-300 group-hover:text-white">Portfolio</span>
              </a>
              <a href="#blog" 
                 class="flex items-center p-3 glass rounded-lg hover:border-tech-purple/50 border border-tech-gray-800 transition group">
                <i data-feather="book-open" class="w-5 h-5 text-tech-gray-400 group-hover:text-tech-purple transition mr-3"></i>
                <span class="text-sm text-tech-gray-300 group-hover:text-white">Blog</span>
              </a>
              <a href="#github" 
                 class="flex items-center p-3 glass rounded-lg hover:border-tech-blue/50 border border-tech-gray-800 transition group">
                <i data-feather="github" class="w-5 h-5 text-tech-gray-400 group-hover:text-tech-blue transition mr-3"></i>
                <span class="text-sm text-tech-gray-300 group-hover:text-white">GitHub</span>
              </a>
            </div>
          </div>
        </div>
        
        <!-- Contact Form -->
        <div class="group relative card-hover">
          <div class="absolute inset-0 bg-gradient-to-r from-tech-blue/10 via-tech-cyan/10 to-tech-purple/10 rounded-3xl blur-xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
          <div class="relative glass rounded-3xl p-8 border border-tech-gray-800 group-hover:border-tech-blue/30 transition">
            <h3 class="text-2xl font-bold text-tech-gray-200 mb-2">Send a Message</h3>
            <p class="text-tech-gray-400 mb-8">Let's start a conversation about your project</p>
            
            <form id="contactForm" class="space-y-6">
              <div class="grid md:grid-cols-2 gap-6">
                <div class="group/input">
                  <label for="name" class="block text-sm font-medium text-tech-gray-400 mb-2 group-hover/input:text-tech-blue transition">Your Name</label>
                  <input type="text" id="name" required
                         class="w-full bg-tech-darker/50 border border-tech-gray-800 rounded-xl px-4 py-3 text-tech-gray-200 focus:outline-none focus:border-tech-blue transition placeholder-tech-gray-600"
                         placeholder="John Doe">
                </div>
                <div class="group/input">
                  <label for="email" class="block text-sm font-medium text-tech-gray-400 mb-2 group-hover/input:text-tech-cyan transition">Email Address</label>
                  <input type="email" id="email" required
                         class="w-full bg-tech-darker/50 border border-tech-gray-800 rounded-xl px-4 py-3 text-tech-gray-200 focus:outline-none focus:border-tech-cyan transition placeholder-tech-gray-600"
                         placeholder="john@example.com">
                </div>
              </div>
              <div class="group/input">
                <label for="subject" class="block text-sm font-medium text-tech-gray-400 mb-2 group-hover/input:text-tech-purple transition">Subject</label>
                <input type="text" id="subject"
                       class="w-full bg-tech-darker/50 border border-tech-gray-800 rounded-xl px-4 py-3 text-tech-gray-200 focus:outline-none focus:border-tech-purple transition placeholder-tech-gray-600"
                       placeholder="Project Inquiry">
              </div>
              <div class="group/input">
                <label for="message" class="block text-sm font-medium text-tech-gray-400 mb-2 group-hover/input:text-tech-blue transition">Message</label>
                <textarea id="message" rows="5" required
                          class="w-full bg-tech-darker/50 border border-tech-gray-800 rounded-xl px-4 py-3 text-tech-gray-200 focus:outline-none focus:border-tech-blue transition placeholder-tech-gray-600 resize-none"
                          placeholder="Tell me about your project..."></textarea>
              </div>
              <button type="submit" 
                      class="w-full bg-gradient-to-r from-tech-blue to-tech-cyan text-tech-darker font-bold py-4 rounded-xl hover:shadow-lg hover:shadow-tech-blue/30 transition-all duration-300 transform hover:-translate-y-1 relative overflow-hidden group/btn">
                <span class="relative z-10">Send Message</span>
                <div class="absolute inset-0 bg-gradient-to-r from-tech-cyan to-tech-purple opacity-0 group-hover/btn:opacity-100 transition-opacity duration-300"></div>
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="relative border-t border-tech-gray-900 py-12">
    <div class="container-narrow">
      <div class="grid md:grid-cols-4 gap-12">
        <div>
          <a href="#" class="flex items-center space-x-3 group mb-6">
            <div class="relative">
              <div class="absolute inset-0 bg-gradient-to-r from-tech-blue to-tech-cyan rounded-xl blur opacity-30 group-hover:opacity-50 transition-opacity"></div>
              <div class="relative w-10 h-10 rounded-xl bg-tech-darker flex items-center justify-center">
                <span class="text-2xl font-bold gradient-text">H</span>
              </div>
            </div>
            <div>
              <div class="font-display font-bold text-xl text-tech-gray-200">HAFIIDH</div>
              <div class="text-xs text-tech-gray-500">Digital Creator & Developer</div>
            </div>
          </a>
          <p class="text-tech-gray-400 text-sm">
            Creating extraordinary digital experiences through code and design.
          </p>
        </div>
        
        <div>
          <h4 class="text-lg font-bold text-tech-gray-200 mb-6">Quick Links</h4>
          <ul class="space-y-3">
            <li><a href="#hero" class="text-tech-gray-400 hover:text-tech-blue transition text-sm">Home</a></li>
            <li><a href="#about" class="text-tech-gray-400 hover:text-tech-cyan transition text-sm">About</a></li>
            <li><a href="#skills" class="text-tech-gray-400 hover:text-tech-purple transition text-sm">Skills</a></li>
            <li><a href="#projects" class="text-tech-gray-400 hover:text-tech-blue transition text-sm">Projects</a></li>
          </ul>
        </div>
        
        <div>
          <h4 class="text-lg font-bold text-tech-gray-200 mb-6">Resources</h4>
          <ul class="space-y-3">
            <li><a href="#blog" class="text-tech-gray-400 hover:text-tech-blue transition text-sm">Blog</a></li>
            <li><a href="#testimonials" class="text-tech-gray-400 hover:text-tech-cyan transition text-sm">Testimonials</a></li>
            <li><a href="#contact" class="text-tech-gray-400 hover:text-tech-purple transition text-sm">Contact</a></li>
            <li><a href="https://drive.google.com/file/d/1ZK7MkbdRxdu8jfDEyJPbupUwI9QUMf6s/view" target="_blank" class="text-tech-gray-400 hover:text-tech-blue transition text-sm">Resume</a></li>
          </ul>
        </div>
        
        <div>
          <h4 class="text-lg font-bold text-tech-gray-200 mb-6">Connect</h4>
          <div class="flex space-x-4">
            <a href="https://github.com/Fiidhanz" target="_blank" 
               class="w-10 h-10 rounded-lg glass border border-tech-gray-800 hover:border-tech-blue flex items-center justify-center hover:bg-tech-blue/10 transition">
              <i data-feather="github" class="w-5 h-5 text-tech-gray-400 hover:text-tech-blue"></i>
            </a>
            <a href="https://www.linkedin.com/in/hafiidh-yupiza-ramadhani-23506b213" target="_blank" 
               class="w-10 h-10 rounded-lg glass border border-tech-gray-800 hover:border-tech-cyan flex items-center justify-center hover:bg-tech-cyan/10 transition">
              <i data-feather="linkedin" class="w-5 h-5 text-tech-gray-400 hover:text-tech-cyan"></i>
            </a>
            <a href="https://instagram.com/upza.sign_" target="_blank" 
               class="w-10 h-10 rounded-lg glass border border-tech-gray-800 hover:border-tech-purple flex items-center justify-center hover:bg-tech-purple/10 transition">
              <i data-feather="instagram" class="w-5 h-5 text-tech-gray-400 hover:text-tech-purple"></i>
            </a>
          </div>
        </div>
      </div>
      
      <div class="border-t border-tech-gray-800 mt-12 pt-8 text-center">
        <p class="text-tech-gray-500 text-sm">&copy; 2025 Hafiidh Yupiza Ramadhani. All rights reserved.</p>
        <p class="text-tech-gray-600 text-xs mt-2">Crafted with passion and cutting-edge technology</p>
      </div>
    </div>
  </footer>

  <!-- Scripts -->
  <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
  
  <script>
    // Initialize AOS
    AOS.init({
      duration: 1200,
      once: true,
      offset: 100,
      easing: 'ease-out-cubic'
    });
    
    // Initialize Feather icons
    feather.replace();
    
    // Advanced Cursor System
    const cursorDot = document.querySelector('.cursor-dot');
    const cursorRing = document.querySelector('.cursor-ring');
    const magneticEffect = document.querySelector('.cursor-magnetic-effect');
    
    let mouseX = 0, mouseY = 0;
    let ringX = 0, ringY = 0;
    let trailHistory = [];
    const trailLength = 20;
    
    // Mouse movement tracking
    document.addEventListener('mousemove', (e) => {
      mouseX = e.clientX;
      mouseY = e.clientY;
      
      // Update cursor dot immediately
      cursorDot.style.left = `${mouseX}px`;
      cursorDot.style.top = `${mouseY}px`;
      
      // Add to trail history
      trailHistory.unshift({ x: mouseX, y: mouseY });
      if (trailHistory.length > trailLength) {
        trailHistory.pop();
      }
      
      // Create trail effect
      if (trailHistory.length > 5) {
        const trail = document.createElement('div');
        trail.className = 'cursor-trail';
        trail.style.left = `${mouseX}px`;
        trail.style.top = `${mouseY}px`;
        document.body.appendChild(trail);
        
        setTimeout(() => {
          trail.remove();
        }, 500);
      }
      
      // Occasionally create sparkles
      if (Math.random() > 0.7) {
        createSparkle(mouseX, mouseY);
      }
    });
    
    // Smooth ring movement
    function updateCursorRing() {
      const dx = mouseX - ringX;
      const dy = mouseY - ringY;
      
      ringX += dx * 0.1;
      ringY += dy * 0.1;
      
      cursorRing.style.left = `${ringX}px`;
      cursorRing.style.top = `${ringY}px`;
      cursorRing.style.transform = `translate(-50%, -50%) scale(${1 + Math.sqrt(dx * dx + dy * dy) * 0.001})`;
      
      magneticEffect.style.left = `${ringX}px`;
      magneticEffect.style.top = `${ringY}px`;
      
      requestAnimationFrame(updateCursorRing);
    }
    
    // Create sparkle effect
    function createSparkle(x, y) {
      const sparkle = document.createElement('div');
      sparkle.className = 'cursor-sparkle';
      sparkle.style.left = `${x}px`;
      sparkle.style.top = `${y}px`;
      
      // Random size and color
      const size = 2 + Math.random() * 4;
      sparkle.style.width = `${size}px`;
      sparkle.style.height = `${size}px`;
      
      const colors = ['#00f3ff', '#0066ff', '#ffd700', '#ff2d95', '#00ff88'];
      sparkle.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
      
      document.body.appendChild(sparkle);
      
      sparkle.style.animation = 'cursor-sparkle 0.3s ease-out forwards';
      
      setTimeout(() => {
        sparkle.remove();
      }, 300);
    }
    
    // Interactive cursor effects
    const interactiveElements = document.querySelectorAll('a, button, .card-hover, input, textarea, .social-card, .blog-card, .certification-card');
    
    interactiveElements.forEach(el => {
      el.addEventListener('mouseenter', (e) => {
        // Magnetic effect
        magneticEffect.style.opacity = '0.3';
        magneticEffect.style.width = '80px';
        magneticEffect.style.height = '80px';
        magneticEffect.style.borderColor = getRandomTechColor();
        
        // Ring effect
        cursorRing.style.borderColor = getRandomTechColor();
        cursorRing.style.transform = 'translate(-50%, -50%) scale(1.8)';
        cursorRing.style.opacity = '0.9';
        
        // Create ripple effect
        createRippleEffect(e.clientX, e.clientY);
        
        // Change cursor dot color
        cursorDot.style.backgroundColor = getRandomTechColor();
        cursorDot.style.boxShadow = `0 0 15px ${getRandomTechColor()}, 0 0 30px ${getRandomTechColor()}`;
      });
      
      el.addEventListener('mouseleave', () => {
        magneticEffect.style.opacity = '0';
        magneticEffect.style.width = '60px';
        magneticEffect.style.height = '60px';
        
        cursorRing.style.borderColor = 'var(--tech-blue)';
        cursorRing.style.transform = 'translate(-50%, -50%) scale(1)';
        cursorRing.style.opacity = '0.7';
        
        cursorDot.style.backgroundColor = 'var(--tech-cyan)';
        cursorDot.style.boxShadow = '0 0 10px var(--tech-cyan), 0 0 20px var(--tech-cyan)';
      });
      
      el.addEventListener('click', (e) => {
        // Click effect
        createClickEffect(e.clientX, e.clientY);
      });
    });
    
    // Ripple effect
    function createRippleEffect(x, y) {
      const ripple = document.createElement('div');
      ripple.className = 'cursor-ripple';
      ripple.style.left = `${x}px`;
      ripple.style.top = `${y}px`;
      
      const colors = ['#00f3ff', '#0066ff', '#8a2be2'];
      ripple.style.borderColor = colors[Math.floor(Math.random() * colors.length)];
      
      document.body.appendChild(ripple);
      
      ripple.style.animation = 'cursor-ripple 0.6s ease-out forwards';
      
      setTimeout(() => {
        ripple.remove();
      }, 600);
    }
    
    // Click effect
    function createClickEffect(x, y) {
      // Create multiple sparkles
      for (let i = 0; i < 8; i++) {
        setTimeout(() => {
          const angle = (i / 8) * Math.PI * 2;
          const distance = 20 + Math.random() * 30;
          const sparkleX = x + Math.cos(angle) * distance;
          const sparkleY = y + Math.sin(angle) * distance;
          
          createSparkle(sparkleX, sparkleY);
        }, i * 30);
      }
    }
    
    function getRandomTechColor() {
      const colors = ['#0066ff', '#00f3ff', '#8a2be2', '#ff2d95', '#00ff88', '#ffd700', '#ff6b35'];
      return colors[Math.floor(Math.random() * colors.length)];
    }
    
    // Start cursor animation
    updateCursorRing();
    
    // Create Neural Network Animation
    function createNeuralNetwork() {
      const container = document.getElementById('neural-network');
      const nodeCount = 35;
      const nodes = [];
      
      // Create nodes
      for (let i = 0; i < nodeCount; i++) {
        const node = document.createElement('div');
        node.className = 'neural-node';
        node.style.left = `${Math.random() * 100}%`;
        node.style.top = `${Math.random() * 100}%`;
        node.style.animationDelay = `${Math.random() * 15}s`;
        container.appendChild(node);
        nodes.push({
          element: node,
          x: parseFloat(node.style.left),
          y: parseFloat(node.style.top)
        });
      }
      
      // Create connections between nearby nodes
      for (let i = 0; i < nodes.length; i++) {
        for (let j = i + 1; j < nodes.length; j++) {
          const dx = Math.abs(nodes[i].x - nodes[j].x);
          const dy = Math.abs(nodes[i].y - nodes[j].y);
          const distance = Math.sqrt(dx * dx + dy * dy);
          
          if (distance < 25) {
            const connection = document.createElement('div');
            connection.className = 'neural-connection';
            connection.style.left = `${Math.min(nodes[i].x, nodes[j].x)}%`;
            connection.style.top = `${Math.min(nodes[i].y, nodes[j].y)}%`;
            connection.style.width = `${dx}%`;
            connection.style.transform = `rotate(${Math.atan2(dy, dx) * (180 / Math.PI)}deg)`;
            connection.style.animationDelay = `${Math.random() * 4}s`;
            container.appendChild(connection);
          }
        }
      }
    }
    
    // Create Digital Rain (Matrix)
    function createDigitalRain() {
      const container = document.getElementById('matrix-layer');
      const chars = '01';
      const digitCount = 100;
      
      for (let i = 0; i < digitCount; i++) {
        const digit = document.createElement('div');
        digit.className = 'digital-rain';
        digit.textContent = chars[Math.floor(Math.random() * chars.length)];
        digit.style.left = `${Math.random() * 100}%`;
        digit.style.animationDelay = `${Math.random() * 20}s`;
        digit.style.animationDuration = `${10 + Math.random() * 20}s`;
        digit.style.opacity = Math.random() * 0.08;
        container.appendChild(digit);
      }
    }
    
    // Create Quantum Particles
    function createQuantumParticles() {
      const container = document.getElementById('particles-layer') || document.getElementById('tech-universe');
      const particleCount = 80;
      
      for (let i = 0; i < particleCount; i++) {
        const particle = document.createElement('div');
        particle.className = 'quantum-particle';
        particle.style.left = `${Math.random() * 100}%`;
        particle.style.top = `${Math.random() * 100}%`;
        particle.style.animationDelay = `${Math.random() * 10}s`;
        container.appendChild(particle);
      }
    }
    
    // Animated Counting
    function animateCounters() {
      const counters = document.querySelectorAll('.animate-count');
      
      counters.forEach(counter => {
        const target = parseInt(counter.getAttribute('data-target'));
        let current = 0;
        const increment = target / 50;
        const duration = 2000;
        
        const updateCounter = () => {
          if (current < target) {
            current += increment;
            counter.textContent = Math.floor(current) + (counter.textContent.includes('/') ? '/7' : '+');
            setTimeout(updateCounter, duration / 50);
          } else {
            counter.textContent = target + (counter.textContent.includes('/') ? '/7' : '+');
          }
        };
        
        updateCounter();
      });
    }
    
    // Animate Skill Bars
    function animateSkillBars() {
      const skillBars = document.querySelectorAll('.skill-progress');
      
      skillBars.forEach(bar => {
        const width = bar.getAttribute('data-width');
        setTimeout(() => {
          bar.style.width = width;
        }, 500);
      });
    }
    
    // GitHub API Integration
    async function fetchGitHubData() {
      try {
        // Fetch GitHub user data
        const response = await fetch('https://api.github.com/users/Fiidhanz');
        const userData = await response.json();
        
        // Update GitHub stats
        document.getElementById('github-repos').textContent = userData.public_repos || '42';
        document.getElementById('github-stars').textContent = '128';
        
        // Fetch recent activity
        const activityResponse = await fetch('https://api.github.com/users/Fiidhanz/events/public?per_page=5');
        const activityData = await activityResponse.json();
        
        const activityContainer = document.getElementById('github-activity');
        activityContainer.innerHTML = '';
        
        activityData.forEach(event => {
          const activityItem = document.createElement('div');
          activityItem.className = 'flex items-start space-x-4 mb-4';
          
          let activityText = '';
          switch (event.type) {
            case 'PushEvent':
              activityText = `Pushed ${event.payload.commits?.length || 1} commit(s) to ${event.repo.name}`;
              break;
            case 'CreateEvent':
              activityText = `Created ${event.payload.ref_type} in ${event.repo.name}`;
              break;
            case 'WatchEvent':
              activityText = `Starred ${event.repo.name}`;
              break;
            case 'ForkEvent':
              activityText = `Forked ${event.repo.name}`;
              break;
            default:
              activityText = `Activity on ${event.repo.name}`;
          }
          
          activityItem.innerHTML = `
            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-tech-blue/20 to-tech-cyan/20 flex items-center justify-center flex-shrink-0">
              <i data-feather="git-commit" class="w-5 h-5 text-tech-cyan"></i>
            </div>
            <div class="flex-1">
              <p class="text-sm text-tech-gray-300">${activityText}</p>
              <p class="text-xs text-tech-gray-500">${new Date(event.created_at).toLocaleDateString()}</p>
            </div>
          `;
          
          activityContainer.appendChild(activityItem);
        });
        
        feather.replace();
        
      } catch (error) {
        console.log('GitHub API error, using fallback data');
        // Fallback data
        document.getElementById('github-repos').textContent = '42';
        document.getElementById('github-stars').textContent = '128';
      }
    }
    
    // Form Submission
    const contactForm = document.getElementById('contactForm');
    if (contactForm) {
      contactForm.addEventListener('submit', (e) => {
        e.preventDefault();
        
        const formData = {
          name: document.getElementById('name').value,
          email: document.getElementById('email').value,
          subject: document.getElementById('subject').value,
          message: document.getElementById('message').value
        };
        
        if (!formData.name || !formData.email || !formData.message) {
          alert('Please fill in all required fields.');
          return;
        }
        
        const button = contactForm.querySelector('button');
        const originalText = button.textContent;
        button.innerHTML = '<span class="relative z-10">✓ Message Sent!</span>';
        button.classList.add('bg-gradient-to-r', 'from-green-500', 'to-emerald-500');
        
        const mailtoLink = `mailto:hafiidhramadhani@gmail.com?subject=${encodeURIComponent(formData.subject || 'Portfolio Contact')}&body=${encodeURIComponent(`Name: ${formData.name}\nEmail: ${formData.email}\n\nMessage:\n${formData.message}`)}`;
        
        setTimeout(() => {
          window.location.href = mailtoLink;
        }, 1000);
        
        setTimeout(() => {
          contactForm.reset();
          button.textContent = originalText;
          button.classList.remove('bg-gradient-to-r', 'from-green-500', 'to-emerald-500');
        }, 3000);
      });
    }
    
    // Mobile Menu
    const mobileMenuButton = document.getElementById('mobileMenuButton');
    if (mobileMenuButton) {
      mobileMenuButton.addEventListener('click', () => {
        const icon = mobileMenuButton.querySelector('i');
        if (icon.getAttribute('data-feather') === 'menu') {
          icon.setAttribute('data-feather', 'x');
          showMobileMenu();
        } else {
          icon.setAttribute('data-feather', 'menu');
          hideMobileMenu();
        }
        feather.replace();
      });
    }
    
    function showMobileMenu() {
      const menu = document.createElement('div');
      menu.className = 'fixed inset-0 z-40 bg-tech-darker/95 backdrop-blur-xl flex flex-col items-center justify-center md:hidden';
      menu.innerHTML = `
        <div class="space-y-8 text-center">
          <a href="#hero" class="block text-2xl text-tech-gray-300 hover:text-tech-blue transition">Home</a>
          <a href="#about" class="block text-2xl text-tech-gray-300 hover:text-tech-cyan transition">About</a>
          <a href="#skills" class="block text-2xl text-tech-gray-300 hover:text-tech-purple transition">Skills</a>
          <a href="#projects" class="block text-2xl text-tech-gray-300 hover:text-tech-teal transition">Projects</a>
          <a href="#certifications" class="block text-2xl text-tech-gray-300 hover:text-tech-yellow transition">Certifications</a>
          <a href="#github" class="block text-2xl text-tech-gray-300 hover:text-tech-green transition">GitHub</a>
          <a href="#contact" class="block text-2xl text-tech-gray-300 hover:text-tech-pink transition">Contact</a>
        </div>
        <button class="absolute top-8 right-8 p-4" onclick="this.parentElement.remove(); feather.replace();">
          <i data-feather="x" class="w-8 h-8 text-tech-gray-200"></i>
        </button>
      `;
      document.body.appendChild(menu);
      feather.replace();
    }
    
    // Typewriter Effect
    const typewriterTexts = [
      "Digital Experiences",
      "Web Applications",
      "User Interfaces",
      "Scalable Solutions",
      "Modern Designs"
    ];
    
    let typewriterIndex = 0;
    let charIndex = 0;
    let isDeleting = false;
    
    function typeWriter() {
      const currentText = typewriterTexts[typewriterIndex];
      const typewriterElement = document.querySelector('.typewriter');
      
      if (!typewriterElement) return;
      
      if (!isDeleting && charIndex <= currentText.length) {
        typewriterElement.textContent = currentText.substring(0, charIndex);
        charIndex++;
        setTimeout(typeWriter, 100);
      } else if (isDeleting && charIndex >= 0) {
        typewriterElement.textContent = currentText.substring(0, charIndex);
        charIndex--;
        setTimeout(typeWriter, 50);
      } else {
        isDeleting = !isDeleting;
        if (!isDeleting) {
          typewriterIndex = (typewriterIndex + 1) % typewriterTexts.length;
        }
        setTimeout(typeWriter, 1000);
      }
    }
    
    // Initialize everything
    window.addEventListener('load', () => {
      // Create all background animations
      createNeuralNetwork();
      createDigitalRain();
      createQuantumParticles();
      
      // Start animations
      setTimeout(() => {
        animateCounters();
        animateSkillBars();
        typeWriter();
        fetchGitHubData();
      }, 1000);
      
      // Animate elements on scroll
      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
          }
        });
      }, { threshold: 0.1 });
      
      document.querySelectorAll('.glass').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(el);
      });
    });
    
    // Prevent default behavior for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const targetId = this.getAttribute('href');
        if (targetId === '#') return;
        
        const targetElement = document.querySelector(targetId);
        if (targetElement) {
          window.scrollTo({
            top: targetElement.offsetTop - 100,
            behavior: 'smooth'
          });
        }
      });
    });
  </script>
</body>
</html>
