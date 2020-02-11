(async function(){
  let scene, renderer, camera, width, height, aspect
  const threeJs = document.getElementById("welcome");
  scene = new THREE.Scene();
  renderer = new THREE.WebGLRenderer({
    antialias: true,
    alpha: true
  });
  renderer.setSize(width, height);
  renderer.setPixelRatio(devicePixelRatio)
  renderer.setClearColor(0x000000, 0);
  threeJs.appendChild(renderer.domElement);
  camera = new THREE.PerspectiveCamera(45, aspect, 1, 1000);
  camera.position.set(0, 30, 400);

  const globalLight = new THREE.AmbientLight(0xffffff, 1);
  const shadowLight = new THREE.DirectionalLight(0xffffff, .5);
  shadowLight.position.set(200, 150, -300);
  const lightTarget = new THREE.Object3D();
  lightTarget.position.set(0, -20, -150)
  const fontSpotLight = new THREE.SpotLight(0xE7FFB5);
  fontSpotLight.position.set(0, -100, 20);
  fontSpotLight.target = lightTarget;
  scene.add(globalLight, shadowLight, fontSpotLight);


  const GLTFLoader = new THREE.GLTFLoader();
  const dracoLoader = new THREE.DRACOLoader();
  const home = await createHome()
  function createHome(){
    return new Promise(resolve=>{
      dracoLoader.setDecoderPath('./js/lib/DRACOLoader.js');
      GLTFLoader.setDRACOLoader(dracoLoader);
      GLTFLoader.load('./model/model.glb', 
        gltf => {
          gltf.scene.position.set(0, -30, 0)
          gltf.scene.rotation.y = Math.PI * .85
          scene.add(gltf.scene)
          resolve(gltf.scene)
        },
        xhr => console.log( ( xhr.loaded / xhr.total * 100 ) + '% loaded' ),
        error => console.log( 'An error happened' )
      );
    })
  }

  const particle = new Particle(4, 0.9, 0.9, 0.7, 500, 50);
  scene.add(particle.particleSystem);

  const fontLoader = new THREE.FontLoader();
  function font(text, x){
    return new Promise(resolve=>{
      fontLoader.load('./js/lib/Montserrat_Regular.json', font => {
        const fontGeo = new THREE.TextBufferGeometry(text, {
          font,
          size: 150,
          height: 15,
          bevelEnabled: true,
          bevelThickness: 1,
          bevelSize: 1,
          bevelOffset: 0,
          bevelSegments: 1
        });
        const fontMat = new THREE.MeshLambertMaterial({color: '#536280'}); 
        const fontModel = new THREE.Mesh(fontGeo, fontMat); 
        fontModel.position.set(x, 120, -300);
        scene.add(fontModel)
        
        resolve(fontModel)
      })
    })
  }
  const text1 = await font('MASTER POCKET', 0)
  const text2 = await font('MASTER POCKET', 2000)

  function handleWindowResize() {
    width = innerWidth;
    height = innerHeight;
    renderer.setSize(width, height);
    camera.aspect = width / height;
    camera.updateProjectionMatrix();
  }
  window.addEventListener("resize", handleWindowResize);

  function render() {
    text1.position.x < -2300 ? text1.position.x = 1700 : text1.position.x = text1.position.x
    text2.position.x < -2300 ? text2.position.x = 1700: text2.position.x = text2.position.x
    text1.position.x -= .5
    text2.position.x -= .5

    particle.update();
    requestAnimationFrame(render);
    renderer.render(scene, camera);
  }
  handleWindowResize();
  render();
})()