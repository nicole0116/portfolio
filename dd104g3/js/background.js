function background() {
  let scene, renderer, camera, width, height, aspect;
  const threeJs = document.getElementById("threeJs");
  scene = new THREE.Scene();
  renderer = new THREE.WebGLRenderer({
    antialias: false,
    alpha: true
  });
  renderer.setSize(width, height);
  renderer.setClearColor(0x000000, 0);
  threeJs.appendChild(renderer.domElement);

  camera = new THREE.PerspectiveCamera(45, aspect, 1, 5000);
  camera.position.set(0, 250, 500);

  function handleWindowResize() {
    width = innerWidth;
    height = innerHeight;
    renderer.setSize(width, height);
    camera.aspect = width / height;
    camera.updateProjectionMatrix();
  }
  window.addEventListener("resize", handleWindowResize);

  const globalLight = new THREE.AmbientLight(0xffffff, 0.8);
  const shadowLight = new THREE.DirectionalLight(0xffffff, 0.2);
  shadowLight.position.set(500, 400, 0);
  scene.add(globalLight, shadowLight);

  let particle = new Particle(2, 0.9, 0.9, 0.7);
  scene.add(particle.particleSystem);

  function render() {
    particle.update();
    requestAnimationFrame(render);
    renderer.render(scene, camera);
  }
  handleWindowResize();
  render();
}
