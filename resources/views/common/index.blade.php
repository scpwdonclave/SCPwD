@extends('custom-logins.app')
@section('content')
<style>
/* body{
  background: linear-gradient(75deg, #2980b9, #8e44ad);
  font-family: montserrat;
} */
.container{
  position: absolute;
  transform: translate(-50%, -50%);
  height: 380px;
  width: 300px;
  text-align: center;
  border-radius: 5px;
}
.front-face, .back-face{
  position: absolute;
  width: 100%;
  height: 100%;
  background: #ebf8f9;
  border-radius: 5px;
  backface-visibility: hidden;
  box-shadow: 0 2px 3px rgba(0,0,0,.2);
  transition: transform .4s linear;
}
.cover{
  background: linear-gradient(75deg, #8e44ad, #2980b9);
  height: 115px;
  width: 100%;
  border-radius: 5px 5px 0 0;
}
.profile{
  height: 115px;
  width: 115px;
  border-radius: 50%;
  padding: 5px;
  background: white;
  margin-top: 40px;
}
.name{
  font-size: 30px;
  padding-top: 75px;
}
.tag{
  padding: 5px 0;
}
.about{
  margin-top: 10px;
  padding: 0px 35px;
  font-size: 15px;
}
h1{
  color: #0d0d0d;
}
p{
  padding: 20px;
  color: #262626;
  text-align: justify;
}
i{
  font-size: 30px;
  padding-left: 20px;
  cursor: pointer;
}
i.fa-facebook-square{
  padding-left: 0;
  color: #4267b2;
}
i.fa-twitter-square{color: #38A1F3}
i.fa-instagram{color: #d72888}
i.fa-youtube{color: #eb1c14}
i.fa-linkedin{color: #0077B5}

.back-face{
  transform: perspective(800px) rotateY(-180deg);
}
.front-face{
  transform: perspective(800px) rotateY(0deg);
}
.container:hover > .back-face{
  transform: perspective(800px) rotateY(0deg);
}
.container:hover > .front-face{
  transform: perspective(800px) rotateY(180deg);
}

</style>
<div class="row d-flex justify-content-between">
    <div class="col-sm-4">
        <div class="container">
            <div class="front-face">
                <div class="cover">
                <img src="profile.png" class="profile">
                </div>
                <div class="name">Evan Smith</div>
                <div class="tag">Web Designer</div>
                <p class="about">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Magni, culpa, voluptatum. Esse recusandae fugit ipsum amet doloremque repellat minima, totam illo fuga facere adipisci doloribus rem modi cum pariatur. Saepe.
                </p>
            </div>
            <div class="back-face">
                <h1>Job Description</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias, perspiciatis. Fugiat inventore porro, ducimus quae iure alias, nesciunt ab a accusantium repellat perspiciatis, pariatur quia perferendis modi blanditiis odio repellendus mollitia cum consequatur! Fuga laudantium id nobis libero totam, ipsum tenetur dolores quaerat officia aspernatur maxime iste, deserunt enim pariatur accusantium dolor excepturi sed quo!</p>
                <i class="fab fa-facebook-square"></i>
                <i class="fab fa-twitter-square"></i>
                <i class="fab fa-instagram"></i>
                <i class="fab fa-youtube"></i>
                <i class="fab fa-linkedin"></i>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="container">
            <div class="front-face">
                <div class="cover">
                <img src="profile.png" class="profile">
                </div>
                <div class="name">Evan Smith</div>
                <div class="tag">Web Designer</div>
                <p class="about">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Magni, culpa, voluptatum. Esse recusandae fugit ipsum amet doloremque repellat minima, totam illo fuga facere adipisci doloribus rem modi cum pariatur. Saepe.
                </p>
            </div>
            <div class="back-face">
                <h1>Job Description</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias, perspiciatis. Fugiat inventore porro, ducimus quae iure alias, nesciunt ab a accusantium repellat perspiciatis, pariatur quia perferendis modi blanditiis odio repellendus mollitia cum consequatur! Fuga laudantium id nobis libero totam, ipsum tenetur dolores quaerat officia aspernatur maxime iste, deserunt enim pariatur accusantium dolor excepturi sed quo!</p>
                <i class="fab fa-facebook-square"></i>
                <i class="fab fa-twitter-square"></i>
                <i class="fab fa-instagram"></i>
                <i class="fab fa-youtube"></i>
                <i class="fab fa-linkedin"></i>
            </div>
        </div>
    </div>
</div>
@endsection