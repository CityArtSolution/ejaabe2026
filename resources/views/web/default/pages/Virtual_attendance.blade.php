@extends(getTemplate().'.layouts.canada_app')

@push('styles_top')
<style>
  body {
    background-color: #f9f9f9;
  }
  .terms-container {
    max-width: 900px;
    margin: 40px auto 60px auto;
    padding: 25px 30px;
    background: #fff;
    box-shadow: 0 2px 8px rgb(0 0 0 / 0.1);
    border-radius: 8px;
    font-family: Arial, sans-serif;
    color: #333;
    line-height: 1.6;
  }
  h1, h2, h3 {
    color: #0056b3;
    font-family: Arial, sans-serif;
  }
  h1 {
    font-size: 26px;
    margin-top: 0;
    margin-bottom: 20px;
    text-align: center;
  }
  h2 {
    font-size: 20px;
    margin-top: 30px;
    margin-bottom: 15px;
  }
  h3 {
    font-size: 18px;
    margin-top: 25px;
    margin-bottom: 10px;
  }
  p {
    font-size: 15px;
    margin-bottom: 15px;
    text-align: justify;
  }
  ul {
    margin-left: 20px;
    margin-bottom: 15px;
  }
  ul li {
    margin-bottom: 8px;
  }
</style>
@endpush 

@section('content')
  <div class="terms-container">
    <h1>Virtual Attendance Policy</h1>

    <h2>E-Learning</h2>
    <p>
      E-learning has become a well-established form of education, relying on the use of technological devices such as tablets and various media types including images, audio, graphics, and charts. It is also known as internet-based learning. E-learning is considered an innovative and effective method of training learners when used correctly as a new educational concept utilizing information technology and communication tools.
    </p>
    <p>
      Many researchers classify e-learning as more effective than traditional classroom education due to its ability to improve learners' performance and enhance their effectiveness in digital-technological domains. In this training style, courses are presented online to learners in the form of instructional videos, images, computer-printed files, and other means.
    </p>
    <p>
      Therefore, e-learning represents a modern revolution in teaching methods and approaches. The nature of e-learning depends on the electronic or virtual delivery of information and training courses, using electronic media for communication, data reception, skill acquisition, and interaction between the center and the trainee, as well as between the trainer and the trainee.
    </p>
    <p>
      This training style does not require the existence of training courses or educational buildings. It eliminates most of the physical components of training and can be described as virtual training in its educational means and realistic in its outcomes.
    </p>

    <h2>Key Advantages of E-Learning</h2>
    <ul>
      <li>Facilitates the process of in-person training and enhances it by allowing trainers in the training center to give courses with the help of the internet.</li>
      <li>Helps learners to study electronically anywhere and anytime.</li>
      <li>Educates a massive number of learners without the restrictions of place or time.</li>
      <li>Assists in considering individual differences among learners due to achieving self-learning.</li>
      <li>Facilitates the exchange of skills and experiences between training institutions.</li>
      <li>Eases and speeds up the update of data and information related to the training content.</li>
      <li>Provides instant and quick assessment, reviewing results, and providing feedback to learners.</li>
      <li>Easy access to information and educational data, and the ability to review others' experiences electronically to reduce time, effort, and cost.</li>
    </ul>

    <h2>E-Learning Styles</h2>

    <h3>1- Synchronous E-Learning</h3>
    <ul>
      <li>A style where both the trainer and the learner meet simultaneously.</li>
      <li>Involves synchronous communication through text, images, and sound.</li>
    </ul>

    <h3>2- Asynchronous E-Learning</h3>
    <ul>
      <li>A form of training that does not require the trainer and the learner to be present simultaneously.</li>
      <li>The trainer can place the training course on the website, and the learner can access it whenever they want by following the center's instructions.</li>
    </ul>

    <h3>3- Blended Learning</h3>
    <ul>
      <li>A style that combines synchronous and asynchronous training.</li>
      <li>Uses multiple communication methods, such as live lectures in the educational center and online communication, as well as personal or self-learning.</li>
    </ul>

    <h2>Virtual Attendance Policy at Positive Interaction</h2>
    <p>
      The policy of synchronous and asynchronous e-learning at Positive Interaction considers attendance virtually for various remote training activities. This is achieved using various technological tools provided by our e-learning platform, equivalent to traditional in-person attendance in terms of passing, duration, hours, and academic designation.
    </p>
  </div>
@endsection
